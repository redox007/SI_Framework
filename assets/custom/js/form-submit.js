// prepare the form when the DOM is ready 
var ajax_options = {
//        target: '#output1', // target element(s) to be updated with server response 
    beforeSubmit: showRequest, // pre-submit callback 
    success: showResponse, // post-submit callback 

    // other available options: 
    //url:       url         // override for form's 'action' attribute 
    //type:      type        // 'get' or 'post', override for form's 'method' attribute 
//    dataType: data_type, // 'xml', 'script', or 'json' (expected server response type) 
    clearForm: true, // clear all form fields after successful submit 
    resetForm: true        // reset the form after successful submit 

            // $.ajax options can be used here too, for example: 
            //timeout:   3000 
};
$(document).ready(function () {

    // bind form using 'ajaxForm' 
    $('body').on('submit', '.ajax-form', function (e) {
        e.preventDefault();
        var data_type = $(this).data('response-type');

        data_type = data_type || 'json';

        ajax_options.dataType = data_type;
//        alert($(this).data('clear'));
        if ($(this).data('clear') == 'off') {
            ajax_options['clearForm'] = false;
            ajax_options['resetForm'] = false;
        } else {
            ajax_options['clearForm'] = true;
            ajax_options['resetForm'] = true;
        }
        $(this).ajaxSubmit(ajax_options);
    });
});

// pre-submit callback 
function showRequest(formData, jqForm, options) {
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData);


    var before_submit = jqForm.data('before_submit');

    if (before_submit) {
        if (!window[before_submit](formData, jqForm, options)) {
            return false;
        }
    }

    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 

    blockUi(jqForm, 'Posting...');

//    alert('About to submit: \n\n' + queryString);

    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true;
}

// post-submit callback 
function showResponse(responseText, statusText, xhr, $form) {
    logme('Ajax response', responseText);

    var after_submit = $form.data('after_submit');

    var type = (responseText.success) ? 'success' : 'error';
    
    unBlockUi($form);
    
    show_noty(responseText.msg, type);

    $form.trigger('aj_form_submitted', responseText , $form);
    
    if (after_submit) {
        window[after_submit](responseText, statusText, xhr, $form);
    }
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 

    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 

    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 
//
//    alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
//            '\n\nThe output div should have already been updated with the responseText.');
} 