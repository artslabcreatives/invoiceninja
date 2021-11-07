/**
 * Hype Sri Lanka (https://hypesl.org)
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */

class ProcessSOFORT {
    constructor(key, stripeConnect) {
        this.key = key;
        this.errors = document.getElementById('errors');
        this.stripeConnect = stripeConnect;
    }

    setupStripe = () => {
        this.stripe = Stripe(this.key);

        if(this.stripeConnect)
            this.stripe.stripeAccount = stripeConnect;

        return this;
    };

    handle = () => {
        document.getElementById('pay-now').addEventListener('click', (e) => {
            document.getElementById('pay-now').disabled = true;
            document.querySelector('#pay-now > svg').classList.remove('hidden');
            document.querySelector('#pay-now > span').classList.add('hidden');

            this.stripe.confirmSofortPayment(
                document.querySelector('meta[name=pi-client-secret').content,
                {
                    payment_method: {
                        sofort: {
                            country: document.querySelector(
                                'meta[name="country"]'
                            ).content,
                        },
                    },
                    return_url: document.querySelector(
                        'meta[name="return-url"]'
                    ).content,
                }
            );
        });
    };
}

const publishableKey = document.querySelector(
    'meta[name="stripe-publishable-key"]'
)?.content ?? '';

const stripeConnect = 
    document.querySelector('meta[name="stripe-account-id"]')?.content ?? ''; 

new ProcessSOFORT(publishableKey, stripeConnect).setupStripe().handle();
