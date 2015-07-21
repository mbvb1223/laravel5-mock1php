<div id='checkout' class='panel panel-default'>
    <div class='panel-heading'>
        <h2 class='panel-title'>
            <a data-toggle='collapse' data-parent='#checkout-page' href='#checkout-content' class='accordion-toggle'>
                Step 1: Checkout Options
            </a>
        </h2>
    </div>
    <div id='checkout-content' class='panel-collapse collapse in'>
        <div class='panel-body row'>
            <div class='col-md-6 col-sm-6'>
                <h3>New Customer</h3>
                <p>Checkout Options:</p>
                <div class='radio-list'>
                    <label>
                        <input type='radio' name='account'  value='register'> Register Account
                    </label>
                    <label>
                        <input type='radio' name='account'  value='guest'> Guest Checkout
                    </label>
                </div>
                <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                <button class='btn btn-primary' type='submit' data-toggle='collapse' data-parent='#checkout-page' data-target='#payment-address-content'>Continue</button>
            </div>
            <div class='col-md-6 col-sm-6'>
                <h3>Returning Customer</h3>
                <p>I am a returning customer.</p>
                <form role='form' action='{{ action('\App\Http\Controllers\Auth\AuthController@postLoginToBuy') }}' method='post'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                    <div class='form-group'>
                        <label for='email-login'>E-Mail</label>
                        <input type='text' class='form-control' name='username'
                               value='{{ old('username')}}' id='username'
                               placeholder='<?php echo Lang::get('messages.users_username'); ?>'
                               required='required'/>
                    </div>
                    <div class='form-group'>
                        <label for='password-login'>Password</label>
                        <input type='password' class='form-control' name='password'
                               id='password'
                               placeholder='<?php echo Lang::get('messages.users_password'); ?>'
                               required='required'/>
                    </div>
                    <a href='#'>Forgotten Password?</a>
                    <div class='padding-top-20'>
                        <button class='btn btn-primary' type='submit'>Login</button>
                    </div>
                    <hr>
                    <div class='login-socio'>
                        <p class='text-muted'>or login using:</p>
                        <ul class='social-icons'>
                            <li><a href='#' data-original-title='facebook' class='facebook' title='facebook'></a></li>
                            <li><a href='#' data-original-title='Twitter' class='twitter' title='Twitter'></a></li>
                            <li><a href='#' data-original-title='Google Plus' class='googleplus' title='Google Plus'></a></li>
                            <li><a href='#' data-original-title='Linkedin' class='linkedin' title='LinkedIn'></a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>