function login () {
  // (A) FORM DATA
  let data = new FormData(document.getElementById("login"));

  // (B) AJAX FETCH
  fetch("5c-login-ajax.php", { method:"post", body:data })
  .then(res => res.json())
  .then(res => {
    if (res.status) {
      // (B1) STORE THE TOKEN IN LOCALSTORAGE
      localStorage.setItem("jwt", res.msg);

      /* (B2) IN INDEXED DATABSE
      IDB.transaction("Settings", "readwrite")
      .objectStore("Settings")
      .add({"jwt":res.msg}); */

      /* (B3) OR EVEN IN STORAGE CACHE
      var jwtBlob = new Blob([res.msg], {type: "text/plain"});
      var urlBlob = URL.createObjectURL(jwtBlob);
      fetch(urlBlob)
      .then(res => {
        caches.open("NAME").then(cache => cache.put("jwt.txt", res));
        URL.revokeObjectURL(urlBlob);
      }); */

      // (B4) DONE
      location.href = "5d-api.html";
    } else { alert(res.msg); }
  })
  .catch(err => console.error(err));
  return false;
}