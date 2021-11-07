/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */

class CheckoutCreditCardAuthorization {
    constructor() {
        this.button = document.querySelector('#pay-button');
    }

    init() {
        this.frames = Frames.init(
            document.querySelector('meta[name=public-key]').content
        );
    }

    handle() {
        this.init();

        Frames.addEventHandler(
            Frames.Events.CARD_VALIDATION_CHANGED,
            (event) => {
                this.button.disabled = !Frames.isCardValid();
            }
        );

        Frames.addEventHandler(Frames.Events.CARD_TOKENIZED, (event) => {
            document.querySelector(
                'input[name="gateway_response"]'
            ).value = JSON.stringify(event);

            document.getElementById('server_response').submit();
        });

        document
            .querySelector('#authorization-form')
            .addEventListener('submit', (event) => {
                this.button.disabled = true;

                event.preventDefault();
                Frames.submitCard();
            });
    }
}

new CheckoutCreditCardAuthorization().handle();
