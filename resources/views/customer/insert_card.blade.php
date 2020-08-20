@extends('layouts.master')
@section('content')
    {{-- Insert payment card --}}
    <div class="row justify-content-center">
        <div class="card w-md-50">
            <div class="card-body">
                <div class="card-title mt-3">
                    <h3>Payment Details</h3>
                    <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                </div>
                <form role="form" action="{{ route('insertcard', Auth::user()->id) }}" class="require-validation"
                    data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_DEVICE_NAME') }}" id="payment-form">
                    @csrf
                    @if (Session::has('card_number'))
                        <div class="alert alert-danger alert-dismissible col-12">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Erorr!!</strong>{{ Session::get('card_number') }}
                        </div>
                    @endif
                    <div class='row'>
                        <div class='col-xs-12 col-12 form-group required'>
                            <label>Name on Card</label>
                            <input name="card_name" class='form-control' size='4' type='text'>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-12 required'>
                            <label class='card-title'>Card Number</label>
                            <input name="number_card" id="number_card" autocomplete='off' class='form-control card-number'
                                maxlength="19" type='text'>
                            @if ($errors->has('number_card'))
                                <div class="error alert-danger text-center">
                                    {{ $errors->first('number_card') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class='row mt-3'>
                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                            <label>CVC</label>
                            <input name="card_cvc" autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                maxlength="3" type='password'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label>Expiration Month</label>
                            <input name="card_expmonth" class='form-control card-expiry-month' placeholder='MM'
                                maxlength="2" minlength="2" type='text'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label>Expiration Year</label>
                            <input name="card_expyear" class='form-control card-expiry-year' placeholder='YYYY'
                                maxlength="4" maxlength="4" type='text'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12 error form-group collapse'>
                            <div class='alert-danger alert'>Please correct the errors and try again.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection

@section('script')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('collapse');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('collapse');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('collapse')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });

    </script>

    <script>
        $(document).ready(function() {
            document.querySelector('#number_card').addEventListener('keydown', (e) => {
                e.target.value = e.target.value.replace(/(\d{4})(\d+)/g, '$1 $2')
            })
            /* Jquery */
            $('#number_card').keyup(function() {
                $(this).val($(this).val().replace(/(\d{4})(\d+)/g, '$1 $2'))
            });
        });

    </script>

@endsection
