/**
 * Hype Sri Lanka (https://hypesl.org)
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */

const linkifyUrls = require('linkify-urls');

document
    .querySelectorAll('[data-ref=entity-terms]')
    .forEach((text) => {
        text.innerHTML = linkifyUrls(text.innerText, {
            attributes: {target: '_blank', class: 'text-primary'}
        });
    });
