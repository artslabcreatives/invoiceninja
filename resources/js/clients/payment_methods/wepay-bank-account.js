/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

class WePayBank {
    initializeWePay() {
        let environment = document.querySelector('meta[name="wepay-environment"]')?.content;

        WePay.set_endpoint(environment === 'staging' ? 'stage' : 'production');

        return this;
    }

    showBankPopup() {
        WePay.bank_account.create({
                client_id: document.querySelector('meta[name=wepay-client-id]')?.content,
                email: document.querySelector('meta[name=contact-email]')?.content
            }, function (data) {
                if (data.error) {
                    errors.textContent = '';
                    errors.textContent = data.error_description;
                    errors.hidden = false;
                } else {
                    document.querySelector('input[name="bank_account_id"]').value = data.bank_account_id;
                    document.getElementById('server_response').submit();
                }
            }, function (data) {
                if (data.error) {
                    errors.textContent = '';
                    errors.textContent = data.error_description;
                    errors.hidden = false;
                }
            }
        );
    }

    handle() {
        this
            .initializeWePay()
            .showBankPopup();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new WePayBank().handle();
});
