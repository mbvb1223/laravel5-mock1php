<?php
namespace App\Http\Controllers;

use App\ColorSizeNumber;
use App\Detailinvoiceimport;
use App\Http\Requests;
use App\Invoiceimport;
use Illuminate\Http\Request;
use App\Http\Requests\ImportInvoiceRequest;
use App\Color;
use App\Product;
use App\Size;
use Illuminate\Support\Facades\Session;
use Lang;
use View;
use Route;

class InvoiceImportController extends Controller
{

    public function __construct()
    {
        $title       = 'Dashboard - Invoice Import';
        $class_name  = substr(__CLASS__, 21);
        $action_name = substr(strrchr(Route::currentRouteAction(), "@"), 1);
        View::share(array(
            'title'       => $title,
            'class_name'  => $class_name,
            'action_name' => $action_name,
        ));

    }

    public function index()
    {
        return view('color.list');
    }

    //Form import Product
    public function import()
    {
        //Get All Product For Option In Select Tag HTML
        $allProduct                         = Product::all()->toArray();
        $allProductForOptionInSelectTagHTML = getAllProductForOptionInSelectTagHTML($allProduct);


        //Get All Color For Option In Select Tag HTML
        $allColor                         = Color::all()->toArray();
        $allColorForOptionInSelectTagHTML = getAllColorForOptionInSelectTagHTML($allColor);

        //Get All Size And Input Number
        $allSize                     = Size::all()->toArray();
        $allAllSizeAndInputTagNumber = getAllSizeAndInputTagNumber($allSize);

        return view('invoiceimport.import')->with([
            'allProductForOptionInSelectTagHTML' => $allProductForOptionInSelectTagHTML,
            'allColorForOptionInSelectTagHTML'   => $allColorForOptionInSelectTagHTML,
            'allAllSizeAndInputTagNumber'        => $allAllSizeAndInputTagNumber
        ]);
    }

    //Save Product to Session
    public function store(ImportInvoiceRequest $request)
    {

        $allRequest = $request->all();
        //Check Input Tag Number In Invoice Import Empty
        $inputNumber           = $allRequest['mapSizeToNumber'];
        $checkInputNumberEmpty = CheckEmptyInputTagNumberInInvoiceImport($inputNumber);
        if ($checkInputNumberEmpty == true) {
            return redirect()->action('InvoiceImportController@import')->withErrors(Lang::get('messages.no_product_in_cart'));
        }

        //Check ID of Product in database
        $idProduct  = $allRequest['product_id'];
        $objProduct = Product::find($idProduct);
        if ($objProduct == null) {
            return redirect()->action('InvoiceImportController@import')->withErrors(Lang::get('messages.product_not_isset_in_database'));
        }

        //Check ID of Product  in database
        $idColor  = $allRequest['color_id'];
        $objColor = Color::find($idColor);
        if ($objColor == null) {
            return redirect()->action('InvoiceImportController@import')->withErrors(Lang::get('messages.color_not_isset_in_database'));
        }

        $sessionCart = Session::get('cart');
        $objInvoiceImport = new Invoiceimport();
        $objInvoiceImport->saveProductToSessionCart($sessionCart, $allRequest);

        return redirect()->action('InvoiceImportController@import')
            ->withSuccess(Lang::get('messages.import_success'));
    }

    //Form View Cart
    public function view()
    {

        $sessionCart = Session::get('cart');
        if (empty($sessionCart)) {
            return redirect()->action('InvoiceImportController@index')->withErrors(Lang::get('messages.no_product_in_cart'));
        }

        $objInvoiceImport          = new Invoiceimport();
        $convertAndSortSessionCart = convertAndSortByKeySessionCart($sessionCart);
        $resultView                = $objInvoiceImport->getViewCartInvoiceImport($convertAndSortSessionCart);
        $viewCart                  = $resultView['cart'];
        $viewCartButton            = $resultView['button'];

        return view('invoiceimport.view')->with([
            'viewCart'       => $viewCart,
            'viewCartButton' => $viewCartButton,

        ]);
    }

    //Update Number for SessionCart in Form ViewCart
    public function update(Request $request)
    {
        $allRequest     = $request->all();
        $sessionCart    = Session::get('cart');
        $mapKeyToNumber = $allRequest['mapKeyToNumber'];

        foreach ($mapKeyToNumber as $key => $number) {
            if ($number == 0) {
                unset($sessionCart[$key]);
                continue;
            }
            $sessionCart[$key]['number'] = $number;
        }
        Session::put('cart', $sessionCart);
        return redirect()->action('InvoiceImportController@view')
            ->withSuccess(Lang::get('messages.create_success'));
    }

    public function delete($id)
    {
        $sessionCart = Session::get('cart');
        if (!array_key_exists($id, $sessionCart)) {
            return redirect()->action('InvoiceImportController@view')->withErrors(Lang::get('messages.this_product_not_isset_in_session'));
        }

        Session::forget('cart.'.$id);
        return redirect()->action('InvoiceImportController@view')
            ->withSuccess(Lang::get('messages.delete_success'));
    }




    public function checkout(Request $request)
    {
        $sessionCart               = Session::get('cart');
        $objInvoiceImport          = new Invoiceimport();
        $convertAndSortSessionCart = convertAndSortByKeySessionCart($sessionCart);
        $resultView                = $objInvoiceImport->getViewCartInvoiceImport($convertAndSortSessionCart);
        $viewCart                  = $resultView['cart'];
        $viewCartButton            = $resultView['button'];


        return view('invoiceimport.checkout')->with([
            'viewCart'       => $viewCart,
            'viewCartButton' => $viewCartButton,

        ]);

    }

    public function checkoutpost(Request $request)
    {
        $sessionCart               = Session::get('cart');
        $convertAndSortSessionCart = convertAndSortByKeySessionCart($sessionCart);
        $sessionUser               = Session::get('user');
        $allRequest                = $request->all();

        $userId                = $sessionUser['id'];
        $allRequest['user_id'] = $userId;

        //Insert to Invoice Import
        $objInvoiceImport = new Invoiceimport();
        autoAssignDataToProperty($objInvoiceImport, $allRequest);
        $objInvoiceImport->save();
        $idLastOfInvoiceImport = $objInvoiceImport->id;

        //Insert to Detail Invoice Import
        $mapProductIdToInformationProduct = Product::mapProductIdToInformationProduct();
        $dateTimeCreatedAndUpdated        = new \DateTime();
        foreach ($convertAndSortSessionCart as $itemCart) {
            $idProduct                              = $itemCart['product_id'];
            $price_import                           = $mapProductIdToInformationProduct[$idProduct]['price_import'];
            $dataInsertToTableDetailInvoiceImport[] = array(
                'product_id'        => $itemCart['product_id'],
                'color_id'          => $itemCart['color_id'],
                'size_id'           => $itemCart['size_id'],
                'number'            => $itemCart['number'],
                'price_import'      => $price_import,
                'invoice_import_id' => $idLastOfInvoiceImport,
                'created_at'        => $dateTimeCreatedAndUpdated,
                'updated_at'        => $dateTimeCreatedAndUpdated
            );
        }
        $objDetailInvoiceImport = new Detailinvoiceimport();
        $objDetailInvoiceImport->insert($dataInsertToTableDetailInvoiceImport);
        /**
         * INSERT TO SIZE-COLOR-NUMBER TABLE
         */
        $arrayWithKeyAsColorSizeNumber = ColorSizeNumber::arrayWithKeyAsColorSizeNumber(); // array[colorid|sizeid|number|]=>info
        $objColorSizeNumber            = new ColorSizeNumber();

        if ($arrayWithKeyAsColorSizeNumber == null) {
            foreach ($convertAndSortSessionCart as $itemCart) {
                $dataInsertToTableDetailInvoiceImport = array(
                    'product_id' => $itemCart['product_id'],
                    'color_id'   => $itemCart['color_id'],
                    'size_id'    => $itemCart['size_id'],
                    'number'     => $itemCart['number'],
                    'created_at' => $dateTimeCreatedAndUpdated,
                    'updated_at' => $dateTimeCreatedAndUpdated
                );
                $objColorSizeNumber->insert($dataInsertToTableDetailInvoiceImport);

            }
        } else {
            foreach ($convertAndSortSessionCart as $itemCart) {
                $key = $itemCart['key'];
                if (array_key_exists($key, $arrayWithKeyAsColorSizeNumber)) {
                    $id                  = $arrayWithKeyAsColorSizeNumber[$key]['id'];
                    $ColorSizeNumberbyId = ColorSizeNumber::find($id);

                    $oldNumber     = $ColorSizeNumberbyId->number;
                    $currentNumber = $itemCart['number'];
                    $newNumber     = $currentNumber + $oldNumber;

                    $ColorSizeNumberbyId->number = $newNumber;
                    $ColorSizeNumberbyId->save();


                } else {
                    $dataInsertToTableDetailInvoiceImport = array(
                        'product_id' => $itemCart['product_id'],
                        'color_id'   => $itemCart['color_id'],
                        'size_id'    => $itemCart['size_id'],
                        'number'     => $itemCart['number'],
                        'created_at' => $dateTimeCreatedAndUpdated,
                        'updated_at' => $dateTimeCreatedAndUpdated
                    );
                    $objColorSizeNumber->insert($dataInsertToTableDetailInvoiceImport);

                }

            }
        }


        return redirect()->action('InvoiceImportController@checkoutpost')
            ->withSuccess(Lang::get('messages.create_success'));

    }

    public function destroy($id)
    {
        $result = Color::find($id);
        if ($result == null) {
            return redirect()->action('ColorController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $result->delete();
        return redirect_success('ColorController@index', Lang::get('messages.delete_success'));
    }

    public function test()
    {
        $values = Session::get('cart');
        dd($values);
    }

    public function test2()
    {

        Session::forget('cart');
    }


}

