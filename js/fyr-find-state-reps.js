  var fyr_latlong = new google.maps.LatLng();

  function fyr_set_map() {

      var mapOptions = {
          center: new google.maps.LatLng(fyr_latlong.lat(), fyr_latlong.lng()),
          zoom: 13,
          mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      var map = new google.maps.Map(document.getElementById("fyr_map_canvas"),
          mapOptions);
  }

  function fyr_ajax_successfn(fyr_results, status, xhr) {

      jQuery.each(fyr_results, function(index, value) {

          if (this.chamber === "lower" && this.district) {
              //window.location.href = '/ad' + this.district;
              var $adem_p = jQuery('<p>');
              $adem_p.attr('id', 'resultsMsg');
              $adem_p.text("Finding progressives in your area...");
              $adem_p.css({
                  "text-align": "center",
                  "color": "white",
                  "padding-top": "15px"
              });
              if (jQuery('#resultsMsg').length) {
                  jQuery('#resultsMsg').remove();
              }
              jQuery('#fyr_find_reps').append($adem_p);


              window.setTimeout(function() {
                  jQuery.ajax({
                      url: '/ad' + value.district + "/",
                      type: "HEAD",
                      cache: false,
                      success: function() {
                          window.location.href = '/ad' + value.district + "/";
                      },
                      error: function() {
                          $adem_p.text("Unfortunately, we do not have any progressives in our database for district " + value.district)
                      },
                      complete: function(xhr, status) {}

                  });
              }, 2000);

          } else {
              var $adem_error = jQuery('<p>');
              $adem_error.text("Sorry, our database can't find any progressives for this area");
              $adem_error.css("text-align", "center");
          }


      });

      fyr_set_map();
  }

  function fyr_ajax_errorfn(xhr, status, strErr) {
      alert("There was an error processing your request. Please try again.");
  }

  function fyr_get_state_rep_data(f) {

      fyr_street_address = document.getElementById("fyr_street_address").value;
      if (!fyr_street_address) {
          alert("Please enter a street address");
          return false;
      }

      fyr_city = document.getElementById("fyr_city").value;
      if (!fyr_city) {
          alert("Please enter a city in California");
          return false;
      }

      fyr_full_address = fyr_street_address + ", " + fyr_city + ", California";

      var fyr_geocoder = new google.maps.Geocoder();

      fyr_geocoder.geocode({
          'address': fyr_full_address
      }, function(results, status) {
          console.log(results);
          if (status == google.maps.GeocoderStatus.OK) {
              fyr_latlong = results[0].geometry.location;
              //  Create the Sundlight Foundation API url request        
              var fyr_slapi_url = "http://openstates.org/api/v1/legislators/geo/?long=" + fyr_latlong.lng() + "&lat=" + fyr_latlong.lat() + "&apikey=" + fyr_plugin_options_for_javascript.fyr_sunlight_key;
              fyr_slapi_url += "&fields=full_name,photo_url,email,url,offices";

              // Create a jQuery ajax request to the sunlight foundation api
              jQuery.ajax({
                  url: fyr_slapi_url,
                  type: "GET",
                  dataType: "jsonp",
                  success: fyr_ajax_successfn,
                  error: fyr_ajax_errorfn,
                  complete: function(xhr, status) {}

              });

          } else {
              if (status = "ZERO_RESULTS") {
                  alert("Sorry, our mapping service does not recognize your address.");
              } else {
                  alert("Sorry, we are unable to process your request due to a mapping service error.");
              }
          }

      });

      return false;

  }