/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('body').on('click', 'a.delete', function (e) {
    var cftext = $(this).data('cftext');
    cftext = cftext  || "Do you want to delete this item?";
    var a = confirm(cftext);
    if (!a) {
        e.preventDefault();
    }
});
function is_string(param) {
    return (typeof param === 'string' || param instanceof String);
}
function blockUi(e, text) {
    text = text || "Processing";
    var element = (is_string(e)) ? $(e) : e;
    element.block({
        message: '<h5>' + text + '</h5>',
        css: {border: '1px solid #a00'}
    });
}
function unBlockUi(e) {
    var element = (is_string(e)) ? $(e) : e;
    element.unblock();
}

