/**
 * Hype Sri Lanka (https://hypesl.org)
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */

class ProcessPRZELEWY24 {
    constructor(key, stripeConnect) {
        this.key = key;
        this.errors = document.getElementById('errors');
        this.stripeConnect = stripeConnect;
    }

    setupStripe = () => {
        this.stripe = Stripe(this.key);

        if(this.stripeConnect)
            this.stripe.stripeAccount = stripeConnect;
        let elements = this.stripe.elements()
        var options = {
            // Custom styling can be passed to options when creating an Element
            style: {
                base: {
                    padding: '10px 12px',
                    color: '#32325d',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    },
                },
            },
        };
        this.p24bank = elements.create('p24Bank', options)
        this.p24bank.mount('#p24-bank-element');
        return this;
    };

    handle = () => {
        document.getElementById('pay-now').addEventListener('click', (e) => {
            let errors = document.getElementById('errors');

            if (document.getElementById('p24-name').value === "") {
                document.getElementById('p24-name').focus();
                errors.textContent = document.querySelector('meta[name=translation-name-required]').content;
                errors.hidden = false;
                return;
            }
            if (document.getElementById('p24-email-address').value === "") {
                document.getElementById('p24-email-address').focus();
                errors.textContent = document.querySelector('meta[name=translation-email-required]').content;
                errors.hidden = false;
                return;
            }
            if (!document.getElementById('p24-mandate-acceptance').checked) {
                document.getElementById('p24-mandate-acceptance').focus();
                errors.textContent = document.querySelector('meta[name=translation-terms-required]').content;
                errors.hidden = false;
                return;
            }

            document.getElementById('pay-now').disabled = true;
            document.querySelector('#pay-now > svg').classList.remove('hidden');
            document.querySelector('#pay-now > span').classList.add('hidden');

            this.stripe.confirmP24Payment(
                document.querySelector('meta[name=pi-client-secret').content,
                {
                    payment_method: {
                        p24: this.p24bank,
                        billing_details: {
                            name: document.getElementById('p24-name').value,
                            email: document.getElementById('p24-email-address').value,
                        },
                    },
                    payment_method_options: {
                        p24: {
                            tos_shown_and_accepted: document.getElementById('p24-mandate-acceptance').checked,
                        },
                    },
                    return_url: document.querySelector('meta[name="return-url"]').content,
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

new ProcessPRZELEWY24(publishableKey, stripeConnect).setupStripe().handle();
