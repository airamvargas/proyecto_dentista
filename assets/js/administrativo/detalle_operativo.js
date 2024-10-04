            let pathArray = window.location.pathname.split('/');
            let id = pathArray[pathArray.length - 1];
            //data_academic();
            sendFormNew();
            initMap()


            function initMap(lat, lng) {
                console.log("soy la latitud" + lat);
                var marker;
                let map;

                if (lat == null && lng == null) {
                    var myLatLng = {
                        lat: 19.398894572801836,
                        lng: -99.15639584258695
                    };

                } else {
                    var myLatLng = {
                        lat: lat,
                        lng: lng
                    };

                }
                map = new google.maps.Map(document.getElementById("map"), {
                    center: myLatLng,
                    zoom: 13,
                });

                const input = document.getElementById("autocomplete");

                marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    draggable: true,
                    title: "Ubicacion"

                });


                google.maps.event.addListener(marker, "dragend", function(event) {
                    var lat = event.latLng.lat();
                    var lng = event.latLng.lng();
                    getReverseGeocodingData(lat, lng);

                });

                function getReverseGeocodingData(lat, lng) {
                    var latlng = new google.maps.LatLng(lat, lng);
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'latLng': latlng
                    }, (results, status) => {
                        if (status !== google.maps.GeocoderStatus.OK) {
                            alert(status);
                        }
                        // This is checking to see if the Geoeode Status is OK before proceeding
                        if (status == google.maps.GeocoderStatus.OK) {
                            console.log(results);
                            address = results[0].formatted_address;
                            $('#calle').val(address);
                            // inicio = $('#autocomplete').val()
                        }
                    });
                }

            }

            $(document).on('click', '#submit_form_busqueda', function() {

                if ($("#calle").val().length < 1) {
                    alert("La direccion es obligatoria");
                    $("#calle").focus();
                    return false;
                } else {
                    $('#loader').toggle();
                    var url_str = BASE_URL + '/Operativo/Hcv_Rest_Identificacion/data_mapa';
                    var loginForm = $("#ficha_update").serializeArray();
                    var loginFormObject = {};
                    $.each(loginForm,
                        function(i, v) {
                            loginFormObject[v.name] = v.value;
                        }
                    );
                    // send ajax
                    $.ajax({
                        url: url_str, // url where to submit the request
                        type: "POST", // type of action POST || GET
                        dataType: 'JSON', // data type
                        data: JSON.stringify(loginFormObject), // post data || get data
                        success: function(result) {
                            //console.log(result);
                            $('#loader').toggle();
                            $('#calle').val(result.formattedAddress);
                            inicio = $('#calle').val();
                            lng = result.longitude;
                            lat = result.latitude,
                                initMap(lat, lng);
                        },
                        error: function(xhr, text_status) {
                            //console.log(xhr, text_status);
                            $('#loader').toggle();
                            $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                        }
                    })
                }
            });

            // function data_academic() {

            //     var url_str = BASE_URL + '/Hcv_Rest_Academic';

            //     $.ajax({
            //         url: url_str,
            //         type: "GET",
            //         dataType: 'json',
            //         success: function(result) {
            //             if (result.status == 200) {

            //                 $('#success').text(result);
            //                 $('#succes-alert').show();
            //                 //reloadData();

            //                 let id = result.data
            //                 let data_length = id.length

            //                 let academico = document.getElementById("academico")

            //                 console.log(academico)

            //                 for (i = 0; i <= data_length; i++) {


            //                     var option = document.createElement("option");
            //                     option.innerHTML = id[i].ACADEMIC_FORMATION;
            //                     option.value = id[i].ID;
            //                     academico.appendChild(option);
            //                 }



            //             } else {
            //                 $('#error').text(result.error);
            //                 $('#error-alert').show();
            //             }
            //             //$('#loader').toggle();

            //         },
            //         error: function(xhr, resp, text) {
            //             console.log(xhr, resp, text);
            //             $('#loader').toggle();
            //             $('#error-alert').show();
            //             $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');

            //         }
            //     })

            // }

            $(document).ready(function() {

                $("#pepe").keyup(function() {
                    var search = document.getElementById("pepe").value;
                    console.log('si es este: ' + search);
                    var searchresult = document.getElementById("searchResult");
                    var url_str = BASE_URL + '/Hcv_Rest_Indigenous_L';
                    var language = {
                        "search": search,
                        "limit": "10",
                        "offset": "0"

                    };
                    console.log(language);
                    $.ajax({
                        url: url_str,
                        type: 'POST',
                        dataType: 'json',
                        data: JSON.stringify(language),
                        success: function(response) {
                            let info = response.data;
                            console.log(info);
                            var len = info.length;
                            $("#searchResult").empty();
                            for (var i = 0; i < len; i++) {
                                var id = info[i].ID;
                                var name = info[i].SCIENTIFIC_NAME;
                                console.log("searchResult")

                                $("#searchResult").append("<li value='" + id + "'>" + name + "</li>");

                            }

                            // binding click event to li
                            $("#searchResult li").bind("click", function() {
                                var value = $(this).text();
                                $("#pepe").val(value);
                                $("#searchResult").empty();
                            });
                        }
                    });
                });
            });


            $(document).ready(function() {
                $("#cp_search").keyup(function() {
                    var search2 = document.getElementById("cp_search").value;
                    let searchresult2 = document.getElementById("searchResult");
                    var url_str = BASE_URL + '/Hcv_Rest_cp';
                    var cp = {
                        "search": search2,
                        "limit": "20",
                        "offset": "0"

                    };
                    if (search2 != "") {
                        let colonia;
                        let alcaldia;
                        let estado;
                        let id;
                        let info;

                        $.ajax({
                            url: url_str,
                            type: 'POST',
                            dataType: 'json',
                            data: JSON.stringify(cp),
                            success: function(response) {
                                info = response.data;
                                var len = info.length;
                                $("#cpResult").empty();
                                for (var i = 0; i < len; i++) {
                                    id = info[i].ID;
                                    var cp = info[i].CP;
                                    colonia = info[i].ASENTAMIENTO;
                                    alcaldia = info[i].MUNICIPIO;
                                    estado = info[i].ESTADO;
                                    allinfo = info[i];
                                    $("#cpResult").append("<li value='" + id + "'>" + cp + ", " + colonia + "</li>");
                                }

                                // binding click event to li
                                $("#cpResult li").bind("click", function() {
                                    var value = $(this).text();
                                    var id2 = this.value
                                    $("#cp_search").val(value);
                                    console.log(info);
                                    console.log(id2)
                                    $("#cpResult").empty();
                                    var len = info.length;
                                    for (var i = 0; i < len; i++) {
                                        if (info[i].ID == id2) {
                                            $("#colonia").val(info[i].ASENTAMIENTO);
                                            $("#delegacion").val(info[i].MUNICIPIO);
                                            $("#estado").val(info[i].ESTADO);
                                            $('#cp_id').val(info[i].ID);
                                            console.log(info[i])
                                        }
                                    }
                                });
                            }
                        });
                    }
                });
            });


            function sendFormNew() {
                $(document).on('click', '#submit_ficha', function() {
                    var url_str =   BASE_URL + '/Hcv_Rest_Identity/create';
                    var loginForm = $("#ficha_description").serializeArray();
                    var loginFormObject = {};
                    $.each(loginForm,
                        function(i, v) {
                            loginFormObject[v.name] = v.value;
                            console.log(loginFormObject)
                        }
                    );
                    // send ajax
                    $.ajax({
                        url: url_str, // url where to submit the request
                        type: "POST", // type of action POST || GET
                        dataType: 'json', // data type
                        data: JSON.stringify(loginFormObject), // post data || get data
                        success: function(result) {
                            if (result.status == 200) {
                                console.log(result);
                                $('#success').text(result.messages.success);
                                $('#succes-alert').show();

                            } else {
                                $('#error').text(result.error);
                                $('#error-alert').show();
                            }

                        },
                        error: function(xhr, resp, text) {
                            console.log(xhr, resp, text);
                            $('#loader').toggle();
                            $('#error-alert').show();
                            $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                            $('#modal_delete').modal('toggle');
                        }
                    })
                });
            }




            $(document).on('click', '.btn-danger', function() {
                let id = $(this).attr('id');
                $('#id_delete').val(id);
                $('#modal_delete').modal('show');
            })




            $('.alert .close').on('click', function(e) {
                $(this).parent().hide();
            });

            function reloadData() {
                $('#loader').toggle();
                sendFormDel.ajax.reload();
                $('#loader').toggle();
            }

            // Datepicker
            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });

            $('#datepickerNoOfMonths').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                numberOfMonths: 2
            });


            $(document).ready(function() {
                $('#genero').change(function(e) {
                    if ($(this).val() === "Otro") {
                        $('#othergender').show();
                    } else {
                        $('#othergender').hide();
                    }
                })
            });

            $(document).ready(function() {
                $('#info').change(function(e) {
                    if ($(this).val() === "Otro") {
                        $('#otherinfo').show();
                    } else {
                        $('#otherinfo').hide();
                    }
                })
            });

            $(document).ready(function() {
                let Checked = null;
                //The class name can vary
                for (let CheckBox of document.getElementsByClassName('check')) {
                    CheckBox.onclick = function() {
                        if (Checked != null) {
                            Checked.checked = false;
                            Checked = CheckBox;
                        }
                        Checked = CheckBox;
                    }
                }
            });