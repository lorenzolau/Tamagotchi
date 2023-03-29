var myFormLogin = document.getElementById('myFormLogin');
var myFormRegister = document.getElementById('myFormRegister');
var btn = document.getElementById('btn');
var loginBtn = document.getElementById('loginBtn');
var registerBtn = document.getElementById('registerBtn');
if(myFormLogin != null || myFormRegister != null || registerBtn != null){
myFormRegister.style.display = "none";
myFormLogin.style.display = "block";
registerBtn.classList.remove('btnstyle');
}

// game variable //
var eat = document.getElementById('eat');
var light = document.getElementById('light');
var play = document.getElementById('play');
var heal = document.getElementById('heal');
var wash = document.getElementById('wash');
var stat = document.getElementById('stat');
var scold = document.getElementById('scold');
var help = document.getElementById('help');
var buttonA = document.getElementById('buttonA');
var buttonB = document.getElementById('buttonB');
var buttonC = document.getElementById('buttonC');

//************** *//

function witchPosition(item){
    var xhr = new XMLHttpRequest();
    var verb = 'POST';
    var route = 'https://pimalo.fr/tamagotchi/game.php';
        
    xhr.open(verb, route);
    xhr.setRequestHeader("Content-Type","application/json;charset=UTF-8");
    xhr.addEventListener('readystatechange', function() {
        if(xhr.readyState === 4) {
            //Si le status n'est pas 200 (HTTP.OK), on alerte l'utilisateur.
            if(xhr.status !== 200) {
                console.log('An error occured. Code: ' + xhr.status + ', Message : ' + xhr.statusText);
               // const result = JSON.parse(xhr.response);
                console.log(xhr.response);
            } else {
                
               // const result = JSON.parse(xhr.response);
                console.log(xhr.response);
            }
        };
    });
    var form = new FormData();

    form.append('type', item);
var json = converToJSON(form);

    xhr.send(json);
}

function converToJSON(datas){
    var object = {};
    datas.forEach((value,key) => object[key] = value);
    return JSON.stringify(object);
}

var positionActuelle = -1;

function buttonAClicked(){
   


const positionArray = ['eat','light','play','heal','wash','stat','scold'];

const arrayLength = positionArray.length;
let item = '';

if(positionActuelle >= arrayLength-1){
    positionActuelle = 0;
}
else{
    positionActuelle += 1;
}

    item = positionArray[positionActuelle];

    switch (item){
        case 'eat':
            scold.style.backgroundImage = "none";
            eat.style.backgroundImage = "url('./images/utensils-solid.svg')";
            witchPosition(item);
            break;
            case 'light':
                eat.style.backgroundImage = "none";
                light.style.backgroundImage = "url('./images/lightbulb-regular.svg')";
                witchPosition(item);
            break;
            case 'play':
                play.style.backgroundImage = "url('./images/baseball-bat-ball-solid.svg')";
                light.style.backgroundImage = "none";
                witchPosition(item);
            break;
            case 'heal':
                heal.style.backgroundImage = "url('./images/hand-holding-medical-solid.svg')";
                play.style.backgroundImage = "none";
                witchPosition(item);
            break;
            case 'wash':
                wash.style.backgroundImage = "url('./images/bath-solid.svg')";
                heal.style.backgroundImage = "none";
                witchPosition(item);
            break;
            case 'stat':
                stat.style.backgroundImage = "url('./images/scale-balanced-solid.svg')";
                wash.style.backgroundImage = "none";
                witchPosition(item);
            break;
            case 'scold':
                scold.style.backgroundImage = "url('./images/face-tired-regular.svg')";
                stat.style.backgroundImage = "none";
                witchPosition(item);
            break;
    }
return item;
}

console.log(buttonAClicked());
function buttonBClicked(){
   

}
function buttonCClicked(){
   

}

function login(){
    myFormRegister.style.display = "none";
    myFormLogin.style.display = "block";
    loginBtn.classList.add('btnstyle');
    registerBtn.classList.remove('btnstyle');

}
function register(){
    myFormLogin.style.display = "none";
    myFormRegister.style.display = "block";
    loginBtn.classList.remove('btnstyle');
    registerBtn.classList.add('btnstyle');
}


function submitRegister()
{
    var user = $('input[name=user]').val();
    var pass = $('input[name=pass]').val();
var pass2 = $('input[name=pass2]').val();
    var email = $('input[name=email]').val();

    if(user != '' && pass!= '' && pass2 != '' && email != '' )
    {
        var formData = {user: user, pass: pass, pass2: pass2, email: email};
        $('#message').html('<span style="color: red">Processing form. . . please wait. . .</span>');
        $.ajax({url: "game.php", type: 'POST', data: formData, success: function(response)
        {
            var res = JSON.parse(response);
            console.log(res);
            if(res.success == true)
                $('#message').html('<span style="color: green">Form submitted successfully</span>');
            else
                $('#message').html('<span style="color: red">Form not submitted. Some error in running the database query.</span>');
        }
        });
    }
    else
    {
        $('#message').html('<span style="color: red">Please fill all the fields</span>');
    }
    
    
} 