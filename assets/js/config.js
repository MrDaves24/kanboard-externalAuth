"use strict";

let to;
let reqs;

window.addEventListener('load', (event) => {
  // Connection tester
  document.getElementById("b-test_connection").addEventListener("click", () => {
    const url = document.getElementById("URL_test_connection").value;

    // Getting datas out of the form
    let datas = {};
    datas.type = document.getElementById("form-ExternalDbAuth_type").value;
    datas.host = document.getElementById("form-ExternalDbAuth_host").value;
    datas.db = document.getElementById("form-ExternalDbAuth_db").value;
    datas.prefix = document.getElementById("form-ExternalDbAuth_prefix").value;
    datas.user = document.getElementById("form-ExternalDbAuth_user").value;
    datas.pwd = document.getElementById("form-ExternalDbAuth_pwd").value;
    datas.port = document.getElementById("form-ExternalDbAuth_port").value;

    // Requesting PHP page to check the connection
    if (jQuery) {
      let r = document.getElementById("connection_result");

      $.post(url, datas)
      .then((msg) => {
        if (msg && msg.status && msg.result && msg.status == "OK" && msg.result == "OK") {
          r.className = "";
          r.innerHTML = document.getElementById("msg-connection-success").innerHTML;
          r.classList.add("alert");
          r.classList.add("alert-success");
        } else {
          throw msg;
        }
      })
      .catch((err) => {
        r.className = "";
        r.innerHTML = document.getElementById("msg-connection-fail").innerHTML;
        r.classList.add("alert");
        r.classList.add("alert-error");

        if (err.responseText) console.warn(err.responseText);
        if (err.msg) {
          if (typeof err.msg === 'string' || err.msg instanceof String) r.innerHTML += "<br>Error : '"+err.msg+"'";
          console.warn(err.msg);
        }
        if (err.err2) {
          if (typeof err.err2 === 'string' || err.err2 instanceof String) r.innerHTML += "<br>Error : '"+err.err2+"'";
          console.warn(err.err2);
        }
        console.warn(err);
      }).then(() => {
        clearTimeout(to);
        to = setTimeout(() => {
          r.className = "";
          r.innerHTML = "";
        }, 5000);
      });
    } else {
      alert("jQuery isn't loaded...");
    }
  });

  // TODO : If disabled, save n remove required ?
  for (let id of ["ExternalDbAuth_user_enabled", "ExternalDbAuth_group_enabled", "ExternalDbAuth_session_enabled"]) {
    const cb = document.getElementsByName(id)[0];
    cb.addEventListener("change", () => {
      cb.parentElement.parentElement.getElementsByClassName("form-children")[0].style.display = (cb.checked ? '' : 'none');
    });
  }
});
