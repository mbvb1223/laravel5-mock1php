<?php
namespace App\Http\Controllers;

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
        $checkInputNumberEmpty = checkEmptyInputTagNumberInInvoiceImport($inputNumber);
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

        $sessionCart      = Session::get('cart');
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
        //dd($sessionCart);
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
        $allRequest  = $request->all();
        $sessionCart = Session::get('cart');

        if (empty($sessionCart)) {
            return redirect()->action('InvoiceImportController@index')->withErrors(Lang::get('messages.cart_empty'));
        }

        $objInvoiceImport = new Invoiceimport();
        $objInvoiceImport->updateNumberForSessionCart($sessionCart, $allRequest);
        return redirect()->action('InvoiceImportController@view')
            ->withSuccess(Lang::get('messages.update_success'));
    }

    //Delete Item Product in SessionCart
    public function delete($id)
    {
        $sessionCart = Session::get('cart');

        if (empty($sessionCart)) {
            return redirect()->action('InvoiceImportController@index')->withErrors(Lang::get('messages.cart_empty'));
        }
        if (!array_key_exists($id, $sessionCart)) {
            return redirect()->action('InvoiceImportController@view')->withErrors(Lang::get('messages.this_product_not_isset_in_session'));
        }

        Session::forget('cart.' . $id);
        return redirect()->action('InvoiceImportController@view')
            ->withSuccess(Lang::get('messages.delete_success'));
    }

    //Form view checkout
    public function checkout()
    {
        $sessionCart = Session::get('cart');
        if (empty($sessionCart)) {
            return redirect()->action('InvoiceImportController@index')->withErrors(Lang::get('messages.cart_empty'));
        }
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

    //Submit Checkout
    public function checkoutpost(Request $request)
    {
        $allRequest  = $request->all();
        $sessionCart = Session::get('cart');

        if (empty($sessionCart)) {
            return redirect()->action('InvoiceImportController@index')->withErrors(Lang::get('messages.cart_empty'));
        }

        $convertAndSortSessionCart = convertAndSortByKeySessionCart($sessionCart);

        //Insert SessionCart to Table Invoice_import
        $objInvoiceImport = new Invoiceimport();
        $objInvoiceImport->saveSessionCartToTableInvoiceImport($allRequest);

        //Insert to Table Detail_invoice Import
        $objInvoiceImport->saveSessionCartToTableDetailInvoiceImport($convertAndSortSessionCart);

        //Insert to Table color_size_number
        $objInvoiceImport->saveSessionCartToTableColorSizeNumber($convertAndSortSessionCart);

        //Forget SessionCart
        Session::forget('cart');

        return redirect()->action('InvoiceImportController@index')
            ->withSuccess(Lang::get('messages.create_success'));

    }


    public function test()
    {
        $values = Session::get('cart');
        dd($values);
    }

    public function test2()
    {
        if (Session::has('cart')) {
            Session::forget('cart');
            return redirect_success('FrontendController@cart', Lang::get('messages.delete_success'));
        }
    }


}

