/**
* PLEASE DO NOT MODIFY THIS FILE. WORK ON THE ES6 VERSION.
* OTHERWISE YOUR CHANGES WILL BE REPLACED ON THE NEXT BUILD.
**/

/**
 * @copyright  (C) 2021 Open Source Matters, Inc. <https://www.gmapfp.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
(function () {
  'use strict';

  window.jSelectItems = function (ed) {
	let i;
	let n;
	let e;
	let id = [];
	let catid = [];
	this.boxes = [].slice.call(ed.querySelectorAll('input[type=checkbox]'));
    const {
      editor
    } = Joomla.getOptions('xtd-gmapfpmap');

    for (i = 0, n = this.boxes.length; i < n; i++) {
      e = this.boxes[i];

      if (e.type === 'checkbox' && e.name !== 'checkall-toggle' && e.checked) {
        if (e.name=='cid[]') {
			id.push(e.value)
		}
        if (e.name=='catid[]') {
			catid.push(e.value)
		}
      }
    }
	
    var tag = '{gmapfp ';
	if (id.length > 0) tag += 'id="'+id.join(',')+'" ';
	if (catid.length > 0) tag += 'catid="'+catid.join(',')+'" ';
	tag += '}';
    window.parent.Joomla.editors.instances[editor].replaceSelection(tag);
    window.parent.Joomla.Modal.getCurrent().close();
    return true;
  };
  
})();