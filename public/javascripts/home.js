function slugify(string) {
    const a = 'àáäâãåăæąçćčđďèéěėëêęğǵḧìíïîįłḿǹńňñòóöôœøṕŕřßşśšșťțùúüûǘůűūųẃẍÿýźžż·/_,:;'
    const b = 'aaaaaaaaacccddeeeeeeegghiiiiilmnnnnooooooprrsssssttuuuuuuuuuwxyyzzz------'
    const p = new RegExp(a.split('').join('|'), 'g')
  
    return string.toString().toLowerCase()
      .replace(/\s+/g, '-') // Replace spaces with -
      .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
      .replace(/&/g, '-and-') // Replace & with 'and'
      .replace(/[^\w\-]+/g, '') // Remove all non-word characters
      .replace(/\-\-+/g, '-') // Replace multiple - with single -
      .replace(/^-+/, '') // Trim - from start of text
      .replace(/-+$/, '') // Trim - from end of text
}

$(document).ready(function () {
    $('.icon-mobile-menu').click(function(){
        $('#sidebar-container').toggleClass('show');
        $('.new-header').toggleClass('show');
    });
    var $paramPopup = $('#sidebar-container');
    $(document).mouseup(function (e) {
        if (!$paramPopup.is(e.target) && $paramPopup.has(e.target).length === 0){
            if($('#sidebar-container').is(':visible')){
                $('#sidebar-container').removeClass('show');
                $('.new-header').removeClass('show');
            }
        }
    });  
});

function valueTreatement(value) {
    var valueArray = value.split("");
    if (valueArray.length === 7)
    {
        return value.slice(0, 2) + "-" + value.slice(2, 5) + "-" + value.slice(5, 7);
    } else if(valueArray.length === 9) {
        return value;
    }
    alert('Votre Numéro d\'immatriculation est incorrecte');

    return ""
    
}

$('#formulaire_demarche').on('change', function (e) {
    var Value = $(".demarche").find(":selected").val();
    if (Value !== "3") {
        $(e.target).parent().siblings().show();
        document.getElementById("calcul").innerHTML = '<button type="submit" class="btn btn-primary btn-sm mx-auto calc-btn">CALCULER</button>';
        $(this).parents("form").next("div#formVN").hide();
        $(this).parents("form").show();
    } else {
        $(e.target).parent().siblings().hide();
        $(this).parents("form").next("div#formVN").show();
        $(this).parents("form").hide();
    }
});

$('#backButton').on('click', function () {
    $('#formulaire_demarche').val(1);
    $('#formulaire_demarche').change();
});

function h2over(x){  
    var p = {
        CTVOdemande :"J'achète un véhicule d'occasion",
        DUPdemande :"J'ai perdu ou on m'a volé ma carte grise",
        DIVNdemande :"J'achète un véhicule neuf",
        DCAdemande :"J'ai changé d'adresse",
        DCdemande :"Je vends mon véhicule"
      };
    var a = x.id;  
    var b = a.concat("h2");
    document.getElementById(b).innerHTML =   p[a];
}
function h2out(x){  
    var a = x.id;  
    var b = a.concat("h2");
    document.getElementById(b).innerHTML =   "";
}
var cookiesChecker = function () {
    var options = {
        cookieKey: "cookies-accepted",
        cookieValue: "Y",
        cookieDays: 365,
        containerId: "cookie-alert-container",
        htmlTemplate: '<div role="alert" class="cookie-alert-message fixed-bottom text-center alert alert-primary"><div class="container mx-auto">En poursuivant votre navigation sur ce site, vous acceptez l\'utilisation de cookies ou technologie similaire pour disposer des services et d\'offres  adaptés à vos centres d\'interêt ainsi que pour la sécurisation des transactions de notre site. <button class="cookie-alert-message-accept-button btn btn-outline-primary" onClick="javascript:cookiesChecker.accept();">J\'accepte</button></div></div>'
    };

    var setCookie = function (key, value, expires) {
        if (typeof expires === 'number') {
            var days = expires, t = expires = new Date();
            t.setDate(t.getDate() + days);
        }

        return (document.cookie = [
            encodeURIComponent(key),
            '=',
            encodeURIComponent(value),
            expires ? '; expires=' + expires.toUTCString() : '',
            '; path=/'
        ].join(''));
    };

    var getCookie = function (key) {
        var cookies = document.cookie.split('; ');
        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decodeURIComponent(parts.shift().replace(/\+/g, ' '));
            var cookie = decodeURIComponent(parts.join('=').replace(/\+/g, ' '));

            if (key && key === name) {
                return decodeURIComponent(cookie.replace(/\+/g, ' '));
            }
        }
        return undefined;
    };

    var checkCookies = function () {
        if (getCookie(options.cookieKey) == options.cookieValue) return;

        var message_container = document.createElement('div');
        message_container.id = options.containerId;
        message_container.innerHTML = options.htmlTemplate;
        document.body.appendChild(message_container);
    };

    var accept = function () {
        setCookie(options.cookieKey, options.cookieValue, options.cookieDays);
        var element = document.getElementById(options.containerId);
        element.parentNode.removeChild(element);
    };

    var init = function (_options) {
        if (_options !== null) {
            for (var key in _options) {
                if (_options.hasOwnProperty(key)) options[key] = _options[key];
            }
        }
        window.onload = checkCookies;
    };

    return {
        accept: accept,
        init: init
    };
}();   