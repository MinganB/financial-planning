/*
Globally available application JS methods.
*/

/**
 * Make an AJAX call to a POST method.
 * @param {string} endpoint Endpoint to call. Do not include the app base url.
 * @param {array} args Arguments to pass with request.
 * @param {string} callback Method to call with response.
 */
function makeAjaxCall(endpoint, args, callback) {
    endpoint = base_url + endpoint;

    var csrfName = $(".txt_csrfname").attr("name");
    var csrfHash = $(".txt_csrfname").val();

    var data = {};
    data[csrfName] = csrfHash;
    
    data['payload'] = JSON.stringify(args);

    $.ajax({
        url: endpoint,
        headers: { "X-Requested-With": "XMLHttpRequest" },
        data: data,
        type: "POST",
        dataType: "json",
        success: function (response) {
          if (response.csrf !== undefined && csrfHash) {
            console.log("CSRF updated.");
            csrfHash.value = response.csrf;
          }
          if (typeof callback === 'function') {
            callback(response);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            let errorMessage =
              "An unknown error occurred processing your request. Please try again later.";
    
            switch (jqXHR.status) {
              case 400:
                errorMessage =
                  "Your request contained invalid data. Please try again.";
                break;
              case 403:
                errorMessage =
                  "Your account credentials could not be authenticated. Please refresh the page and try again.";
                break;
              case 403:
                errorMessage = "You don't have permission to perform this action.";
                break;
              case 404:
                errorMessage = "The requested resource was not found.";
                break;
              case 500:
                errorMessage =
                  "A server-side error occured. Please contact ClientManager Support.";
                break;
            }
    
            console.log("AJAX error: " + errorMessage);

          console.log([jqXHR, textStatus, errorThrown]);
          if (callback) {
            callback(null); // Call the callback function with null indicating an error
          }
        },
      });
}
