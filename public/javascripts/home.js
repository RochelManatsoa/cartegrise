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

$(document).ready(function() {
    $(".Navigation").sticky({ topSpacing: 0 });

    $('#voir_plus_button').on('click', function() { $('.voir_plus_content_car').toggle();
        $('.voir_plus_content_car').parents('.list-grid').find('.btn').toggleClass('collapsed'); });
    $('#more-details-tax').on('click', function() { $('.voir_plus_content_taxes').toggle();
        $('.voir_plus_content_taxes').parents('.list-grid').find('.btn').toggleClass('collapsed'); });
    $('.icon-mobile-menu').click(function() {
        $('#sidebar-container').toggleClass('show');
        $('.new-header').toggleClass('show');
    });
    var $paramPopup = $('#sidebar-container');
    $(document).mouseup(function(e) {
        if (!$paramPopup.is(e.target) && $paramPopup.has(e.target).length === 0) {
            if ($('#sidebar-container').is(':visible')) {
                $('#sidebar-container').removeClass('show');
                $('.new-header').removeClass('show');
            }
        }
    });

    //aside_right
    $("#aside_right").sticky({
        topSpacing: 200, 
        bottomSpacing: 1100
    });


});

    $('#formulaire_demarche').on('change', function(e) {
        var Value = $(".demarche").find(":selected").val();
        if (Value === "3") {
            $(e.target).parent().siblings().hide();
            $("div#formVN").show();
            $("div#formDC").hide();
            $(this).parents("form").hide();
        } else if (Value === "5") {
            $(e.target).parent().siblings().hide();
            $("div#formDC").show();
            $("div#formVN").hide();
            $(this).parents("form").hide();
        } else {
            $(e.target).parent().siblings().show();
            document.getElementById("calcul").innerHTML = '<button type="submit" class="btn-calcuer btn btn-blue">CALCULER <i class="icomoon icon-right-arrow"></i></button>';
            $("div#formVN").hide();
            $("div#formDC").hide();
            $(this).parents("form").show();
        }
        $("#formulaire_demarche").next("div.select-styled").text($(".demarche ul.select-options").eq(0).find("li[rel='" + $(this).val() + "']").text());
        //     $this.val($(this).attr("rel"));
        // .val();
    });
    $(function() {
        /*$('a[href*=\\#]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top }, 500, 'linear');
        });*/
        var jump=function(e)
        {
            if (e){
                e.preventDefault();
                var target = $(this).attr("href");
            }else{
                var target = location.hash;
            }

            $('html,body').animate({
                scrollTop: $(target).offset().top -  130
            },700,function(){
                location.hash = target;
            });

        }

        $('a[href*=\\#]').bind("click", jump);

        if (location.hash){
            setTimeout(function(){
                $('html, body').scrollTop(0).show();
                jump();
            }, 0);
        }else{
            $('html, body').show();
        }
    });




    $('.block_form select').each(function() {
        var $this = $(this),
            numberOfOptions = $(this).children('option').length;

        $this.addClass('select-hidden');
        $this.wrap('<div class="select"></div>');
        $this.after('<div class="select-styled"></div>');

        var $styledSelect = $this.next('div.select-styled');
        $styledSelect.text($this.children('option').eq(0).text());

        var $list = $('<ul />', {
            'class': 'select-options'
        }).insertAfter($styledSelect);

        for (var i = 0; i < numberOfOptions; i++) {
            $('<li />', {
                text: $this.children('option').eq(i).text(),
                rel: $this.children('option').eq(i).val()
            }).appendTo($list);
        }

        var $listItems = $list.children('li');

        $styledSelect.click(function(e) {
            e.stopPropagation();
            $('div.select-styled.active').not(this).each(function() {
                $(this).removeClass('active').next('ul.select-options').hide();
            });
            $(this).toggleClass('active').next('ul.select-options').toggle();
        });

        $listItems.click(function(e) {
            e.stopPropagation();
            $styledSelect.text($(this).text()).removeClass('active');
            $this.val($(this).attr('rel'));
            $this.change();
            $list.hide();
        });

        $(document).click(function() {
            $styledSelect.removeClass('active');
            $list.hide();
        });

    });

    // Mobile nav
    $('.nav').append($('<div class="nav-mobile"><span></span></div>'));
    $('.nav-item').has('ul').prepend('<span class="nav-click"><i class="icomoon icon-arrow-down"></i></span>');
    $('.nav-mobile').click(function() {
        this.classList.toggle('active');
        $('.nav-list').toggle();
    });

    $('.nav-list').on('click', '.nav-click', function() {
        $(this).siblings('.nav-sub-menu').toggle();
        $(this).children('.icon-arrow-down').toggleClass('nav-rotate');

    });

    $('#usrMobile').click(function() {
        this.classList.toggle('active');
        $('.sub-infos').toggle();
    });



    //fixed
    if (window.matchMedia("(min-width: 1750px)").matches) {
        $('#right_formulaireFx').find('.form_demarche').append($('.demarche_block'));
    } else {
        $('#col_formulaireFx').find('.form_demarche').append($('.demarche_block'));
    }
    

    //doc-telechargeable
    $(".js-toggle").on("click", function () {
        $(this).parent().next(".toggle-content").toggle();
    });


    //flash block
    $(".flash_block").delay(5000).fadeOut(400);


    function h2over(x) {
        var p = {
            CTVOdemande: "J'achète un véhicule d'occasion",
            DUPdemande: "J'ai perdu ou on m'a volé ma carte grise",
            DIVNdemande: "J'achète un véhicule neuf",
            DCAdemande: "J'ai changé d'adresse",
            DCdemande: "Je vends mon véhicule"
        };
        var a = x.id;
        var b = a.concat("h2");
        document.getElementById(b).innerHTML = p[a];
    }

    function h2out(x) {
        var a = x.id;
        var b = a.concat("h2");
        document.getElementById(b).innerHTML = "";
    }


    var cookiesChecker = function() {
        var options = {
            cookieKey: "cookies-accepted",
            cookieValue: "Y",
            cookieDays: 365,
            containerId: "cookie-alert-container",
            htmlTemplate: '<div role="alert" class="cookie-alert-message fixed-bottom text-center alert alert-primary"><div class="container mx-auto">En poursuivant votre navigation sur ce site, vous acceptez l\'utilisation de cookies ou technologie similaire pour disposer des services et d\'offres  adaptés à vos centres d\'interêt ainsi que pour la sécurisation des transactions de notre site. <button class="cookie-alert-message-accept-button btn btn-outline-primary" onClick="javascript:cookiesChecker.accept();">J\'accepte</button></div></div>'
        };

        var setCookie = function(key, value, expires) {
            if (typeof expires === 'number') {
                var days = expires,
                    t = expires = new Date();
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

        var getCookie = function(key) {
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

        var checkCookies = function() {
            if (getCookie(options.cookieKey) == options.cookieValue) return;

            var message_container = document.createElement('div');
            message_container.id = options.containerId;
            message_container.innerHTML = options.htmlTemplate;
            document.body.appendChild(message_container);
        };

        var accept = function() {
            setCookie(options.cookieKey, options.cookieValue, options.cookieDays);
            var element = document.getElementById(options.containerId);
            element.parentNode.removeChild(element);
        };

        var init = function(_options) {
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

        //Autocomplete
    //AutoComplete
    $( function() {
        $.widget( "custom.combobox", {
            _create: function() {
                this.wrapper = $( "<span>" )
                    .addClass( "custom-combobox" )
                    .insertAfter( this.element );
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function() {
                var selected = this.element.children( ":selected" ),
                    value = selected.val() ? selected.text() : "";

                this.input = $( "<input>" )
                    .appendTo( this.wrapper )
                    .val( value )
                    .attr( "title", "" )
                    .addClass( "form-control ui-widget ui-widget-content ui-state-default ui-corner-left" )
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: $.proxy( this, "_source" )
                    })
                    .tooltip({
                        classes: {
                            "ui-tooltip": "ui-state-highlight"
                        }
                    });

                this._on( this.input, {
                    autocompleteselect: function( event, ui ) {
                        ui.item.option.selected = true;
                        this._trigger( "select", event, {
                            item: ui.item.option
                        });
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function() {
                var input = this.input,
                    wasOpen = false;

                $( "<i>" )
                    .attr( "tabIndex", -1 )
                    .appendTo( this.wrapper )
                    .removeClass( "ui-corner-all" )
                    .addClass( "custom-combobox-toggle icon icon-arrow-down" )
                    .on( "mousedown", function() {
                        wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                    })
                    .on( "click", function() {
                        input.trigger( "focus" );
                        // Close if already visible
                        if ( wasOpen ) {
                            return;
                        }

                        // Pass empty string as value to search for, displaying all results
                        input.autocomplete( "search", "" );
                    });
            },

            _source: function( request, response ) {
                var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                response( this.element.children( "option" ).map(function() {
                    var text = $( this ).text();
                    if ( this.value && ( !request.term || matcher.test(text) ) )
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }) );
            },

            _removeIfInvalid: function( event, ui ) {

                // Selected an item, nothing to do
                if ( ui.item ) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                this.element.children( "option" ).each(function() {
                    if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if ( valid ) {
                    return;
                }

                // Remove invalid value
                this.input
                    .val( "" )
                    .attr( "title", value + " didn't match any item" )
                    .tooltip( "open" );
                this.element.val( "" );
                this._delay(function() {
                    this.input.tooltip( "close" ).attr( "title", "" );
                }, 2500 );
                this.input.autocomplete( "instance" ).term = "";
            },

            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });

        $( "#formulaire_codePostal" ).combobox();
        $('#AutoCompleteCP').find('.select').prepend($('ul#ui-id-1'));
    } );