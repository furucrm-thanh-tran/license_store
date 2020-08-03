@extends('layouts.master')
@section('content')
{{-- Insert payment card --}}
<div class="container">


    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="card">
                <div class="card-title display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >
                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <form
                            role="form"
                            action="{{ route('insertcard',Auth::user()->id) }}"
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="pk_test_51H7XCjBZo2jHPYhTztHCfF41vWOknXAyZIUKPL07ZbWITXnmITofSHlBKLIVrI2cwrtuASyT3OclONZ7LyTKOSmq00D9dB180q"
                            id="payment-form">
                        @csrf

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label>
                                <input name="card_name" class='form-control' size='4' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='card-title'>Card Number</label>
                                <input name="card_number" id="card_number" autocomplete='off' class='form-control card-number' maxlength="19" type='text' >
                                @if ($errors->has('card_number'))
                                    <div class="error alert-danger text-center">
                                        {{ $errors->first('card_number')}}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label>
                                <input name="card_cvc" autocomplete='off'class='form-control card-cvc' placeholder='ex. 311' maxlength="3"type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label>
                                <input name="card_expmonth" class='form-control card-expiry-month' placeholder='MM' maxlength="2"type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label>
                                <input name="card_expyear" class='form-control card-expiry-year' placeholder='YYYY' maxlength="4" type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-md-12 error form-group collapse'>
                                <div class='alert-danger alert'>Please correct the errors and try again.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
                            </div>
                        </div>

                </form>
                </div>
            </div>
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
                         'textarea'].join(', '),
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
$(document).ready(function(){
    document.querySelector('#card_number').addEventListener('keydown', (e) => {
    e.target.value = e.target.value.replace(/(\d{4})(\d+)/g, '$1 $2')
    })
    /* Jquery */
    $('#card_number').keyup(function() {
    $(this).val($(this).val().replace(/(\d{4})(\d+)/g, '$1 $2'))
    });
});
</script>

@endsection
