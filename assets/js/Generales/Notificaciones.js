
let getNotificacion = () => {
    let url = `${BASE_URL}Api/Generales/Notificaciones/`;

    fetch(url).then(response => response.json()).catch(err =>(err))
    .then(response => {
        moment.locale();  
       let total = response.length;
       if(total >0){
        $('#total-noti').text("("+total+")");
        $('#ajxnoti').children().remove();

        response.forEach((v,i) => {
            let notificacion = `<a href="${BASE_URL}${v.url}" class="media-list-link read">
            <div class="media pd-x-20 pd-y-15">
              <img src="${BASE_URL}/../../../assets/img/doisy.png" class="wd-60 rounded-circle">
              <div class="media-body">
                <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">${v.mensaje}</strong> ${v.sub_mensaje}</p>
                <span class="tx-12">${moment(v.date).format('LL')} ${moment(v.date).format('h:mm a')}</span>
              </div>
            </div>
          </a>`
          $('#ajxnoti').append(notificacion);
           
        });
       }

    }).catch(err =>(err));
    setTimeout(getNotificacion, 60000);
}


  getNotificacion();



