

<?php $__env->startSection('style'); ?>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div id="success" style="display:none;" class="col-md-8 text-center h3 p-4 bg-success text-light rounded">
                Purchase completed successfully
            </div>
            <?php if(session('warning')): ?>
                <div class="col-md-8 text-center h3 p-4 bg-success text-light rounded">
                    Purchase completed successfully
                </div>
            <?php endif; ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Pay using credit card
                    </div>
                    <form method="POST" action="/checkout" class="card-form mt-3 mb-3 p-4">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="payment_method" class="payment-method">
                        <input class="StripeElement mb-3" name="card_holder_name" placeholder="Card holder name">
                        <div class="">
                            <div id="card-element"></div>
                        </div>
                        <div id="card-errors" role="alert"></div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn bg-cart pay">
                                pay <?php echo e($total); ?> $ <span class="icon" hidden><i class="fas fa-sync fa-spin"></i></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        let stripe = Stripe("<?php echo e(env('STRIPE_KEY')); ?>")
        let elements = stripe.elements()
        let style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
        let card = elements.create('card', {style: style})
        card.mount('#card-element')
        let paymentMethod = null
        $('.card-form').on('submit', function (e) {
            $('button.pay').attr('disabled', true)
            if (paymentMethod) {
                return true
            }
            stripe.confirmCardSetup(
                "<?php echo e($intent->client_secret); ?>",
                {
                    payment_method: {
                        card: card,
                        billing_details: {name: $('.card_holder_name').val()}
                    }
                }
            ).then(function (result) {
                if (result.error) {
                    toastr.error('The data you entered contains errors! Check it out again')
                    $('button.pay').removeAttr('disabled')
                } else {
                    paymentMethod = result.setupIntent.payment_method
                    $('.payment-method').val(paymentMethod)
                    $('.card-form').submit()
                    $('span.icon').removeAttr('hidden');
                    $('button.pay').attr('disabled',true);
                }
            })
            return false
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\server\1-web devlopment\2-back_end\2-laravel\BookStore\resources\views/credit/checkout.blade.php ENDPATH**/ ?>