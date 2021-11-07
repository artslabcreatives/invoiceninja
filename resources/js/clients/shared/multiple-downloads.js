/**
 * Hype Sri Lanka (https://hypesl.org)
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */

const appendToElement = (parent, value) => {
    let _parent = document.getElementById(parent);

    let _possibleElement = _parent.querySelector(`input[value="${value}"]`);

    if (_possibleElement) {
        return _possibleElement.remove();
    }

    let _temp = document.createElement('INPUT');

    _temp.setAttribute('name', 'file_hash[]');
    _temp.setAttribute('value', value);
    _temp.hidden = true;

    _parent.append(_temp);
};

window.appendToElement = appendToElement;
