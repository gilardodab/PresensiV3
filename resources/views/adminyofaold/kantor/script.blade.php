

<script type="text/javascript">
$(document).on('click', '.delete', function(event) {
    event.preventDefault(); // Prevent default form submission

    var form = $(this).closest('form'); // Find the closest form
    var formAction = form.attr('action'); // Get form action URL

    swal({
        text: "Anda yakin menghapus data ini?",
        icon: "warning",
        buttons: {
            cancel: true,
            confirm: true,
        }
    }).then((value) => {
        if (value) {
            loading(); // Show loading indicator if implemented

            $.ajax({
                url: formAction,
                type: 'DELETE',
                data: form.serialize(), // Serialize form data
                success: function(data) {
                    console.log('Success response:', data); // Log success response for debugging
                    if (data.status === 'success') {
                        swal({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus!',
                            icon: 'success',
                            timer: 1500,
                            buttons: false // Hide buttons if timer is used
                        }).then(() => {
                            location.reload(); // Reload page after showing success message
                        });
                    } else {
                        swal({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error',
                            timer: 1500,
                            buttons: false // Hide buttons if timer is used
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error response:', xhr.responseText); // Log error response for debugging
                    swal({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan pada server.',
                        icon: 'error',
                        timer: 1500,
                        buttons: false // Hide buttons if timer is used
                    });
                }
            });
        } else {
            return false; // If canceled, do nothing
        }
    });
});




    navigator.geolocation.getCurrentPosition(function(location) {
    var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
  
    $("#Latitude").val(location.coords.latitude);
    $("#Longitude").val(location.coords.longitude).keyup();
  
    var curLocation = [0, 0];
    if (curLocation[0] == 0 && curLocation[1] == 0) {
      curLocation = latlng;
    }
    var map = L.map('MapLocation').setView(curLocation, 20);
    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    map.attributionControl.setPrefix(false);
    var marker = new L.marker(curLocation, {
      draggable: 'true'
    });
  
      lc = L.control.locate({
        strings: {
            title: "Tunjukkan di mana saya berada!"
        }
      }).addTo(map);
  
    marker.on('dragend', function(event) {
      var position = marker.getLatLng();
      marker.setLatLng(position, {
        draggable: 'true'
      }).bindPopup(position).update();
      $("#Latitude").val(position.lat);
      $("#Longitude").val(position.lng).keyup();
    });
  
    $("#Latitude, #Longitude").change(function() {
      var position = [parseInt($("#Latitude").val()), parseInt($("#Longitude").val())];
      marker.setLatLng(position, {
        draggable: 'true'
      }).bindPopup(position).update();
      map.panTo(position);
    });
    map.addLayer(marker);
  });
  </script>