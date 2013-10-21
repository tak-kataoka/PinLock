
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Pinlock Widget</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
        <style type="text/css">
        * {-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;}
        form {float: left;width: 75%;}
        .hidden {visibility: hidden;opacity: 0;display: none;}
        .cpin_passwordcontainer {float: left;width: 100%;position: relative;border: 1px solid #333;border-radius: 50%;}
        .cpin_holder {position: absolute;margin: auto;top: 0;bottom: 0;left: 0;right: 0;width: 50%;height: 50%;float: left;}
        .cpin_button {margin: 1%;width: 31.3333333333%;height: 31.3333333333%;padding: 0;background:none;border: 1px solid #333;border-radius: 50%;font-size: 62px;position: relative;}
        .cpin_button:focus { outline: none!important;}
        .cpin_button span {position: absolute;margin: auto;top: 0;left: 0;right: 0;bottom: 0;float: left;width: 65%;height: 65%;}
        .cpin_holder.cl span {box-shadow: 1px 1px 3px 0 rgba(0,0,0,0.5) inset;}
        </style>
    </head>
    <body>
        <form>
            <input type="password" id="formpwdelement" />
        </form>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="tr.js"></script>
        <script type="text/javascript">

            $(document).ready(function($) {
                $('#formpwdelement').pinLock({'vv':25, initinfo: "kek"})
            });


            ;(function($, window, document, undefined) {
                "use strict"

                var pluginName = 'pinLock',
                    defaults = {
                        propertyName: "value",
                        initinfo: "zold"
                    },
                    symbols = {
                        'll' : [{'value':'A', 'next':'gl'},{'value':'B', 'next':'cl'},{'value':'C', 'next':'sl'},{'value':'D', 'next':'nl'},{'value':'E', 'next':'pl'},{'value':'F', 'next':'gl'},{'value':'G', 'next':'cl'},{'value':'H', 'next':'sl'},{'value':'I', 'next':'nl'}],
                        'gl' : [{'value':'Δ', 'next':'ll'},{'value':'Θ', 'next':'cl'},{'value':'Λ', 'next':'sl'},{'value':'Ξ', 'next':'nl'},{'value':'Σ', 'next':'pl'},{'value':'Π', 'next':'ll'},{'value':'Φ', 'next':'cl'},{'value':'Ψ', 'next':'sl'},{'value':'Ω', 'next':'nl'}],
                        'cl' : [{'value':'ff0000', 'next':'ll'},{'value':'00b22f', 'next':'gl'},{'value':'000acd', 'next':'sl'},{'value':'a3a3a3', 'next':'nl'},{'value':'e900db', 'next':'pl'},{'value':'e6e900', 'next':'ll'},{'value':'e96800', 'next':'gl'},{'value':'fbfbfb', 'next':'sl'},{'value':'0d0d0d', 'next':'nl'}],
                        'sl' : [{'value':'♠', 'next':'ll'},{'value':'♥', 'next':'gl'},{'value':'♦', 'next':'cl'},{'value':'♣', 'next':'nl'},{'value':'✚', 'next':'pl'},{'value':'★', 'next':'ll'},{'value':'➔', 'next':'gl'},{'value':'■', 'next':'cl'},{'value':'▲', 'next':'nl'}],
                        'nl' : [{'value':'1', 'next':'ll'},{'value':'2', 'next':'gl'},{'value':'3', 'next':'cl'},{'value':'4', 'next':'sl'},{'value':'5', 'next':'pl'},{'value':'6', 'next':'ll'},{'value':'7', 'next':'gl'},{'value':'8', 'next':'cl'},{'value':'9', 'next':'sl'}],
                        'pl' : [{'value':'♒', 'next':'ll'},{'value':'♉', 'next':'gl'},{'value':'♌', 'next':'cl'},{'value':'♈', 'next':'sl'},{'value':'♊', 'next':'nl'},{'value':'♍', 'next':'ll'},{'value':'♐', 'next':'gl'},{'value':'♋', 'next':'cl'},{'value':'♎', 'next':'sl'}]
                    },
                    container = null,

                    shuffle = function(a, b) {
                       return Math.random() > 0.5 ? -1 : 1;
                    },
                    holder = null,
                    keys = null,
                    selectedkey = null,
                    labels = null,
                    animation = null;

                function Plugin(element, options) {
                    this.element = element;
                    this.options = $.extend({}, defaults, options);
                    this._defaults = defaults;
                    this._name = pluginName;
                    this.init();
                };

                Plugin.prototype.init = function () {
                    holder = document.createElement('div');
                    keys = Object.keys(symbols);
                    selectedkey = keys[Math.floor(Math.random() * keys.length)];
                    labels = symbols[selectedkey].sort(shuffle);
                    $(this.element).wrap('<div class="cpin_passwordcontainer"/>');
                    container = this.element.parentNode;
                    this.element.className += ' hidden';
                    holder.className = 'cpin_holder';
                    for(var i=0; i<9; i+=1){
                        var b = document.createElement('button'),
                            s = document.createElement('span');
                        b.className = 'cpin_button';
                        if (selectedkey=='cl') {
                            s.style.backgroundColor = '#'+labels[i].value;
                            s.innerHTML = '';
                        } else {
                            s.style.backgroundColor = '';
                            s.innerHTML = labels[i].value;
                        }
                        b.appendChild(s);
                        b.dataset.next = labels[i].next;
                        b.addEventListener('click', this.clickHandler, false);
                        holder.appendChild(b);
                        $(holder).addClass(selectedkey);
                    }
                    container.appendChild(holder);

                    $.each($('.cpin_button span'), function(index, val) {
                        if (val.style['transform'] !== undefined) {
                            val.style.transform = 'rotate(0deg) scale(1, 1)';
                        } else if (val.style['webkitTransform'] !== undefined) {
                            val.style.webkitTransform = 'rotate(0deg) scale(1, 1)';
                        } else if (val.style['MozTransform'] !== undefined) {
                            val.style.MozTransform = 'rotate(0deg) scale(1, 1)';
                        } else if (val.style['msTransform'] !== undefined) {
                            val.style.msTransform = 'rotate(0deg) scale(1, 1)';
                        } else {
                            throw new Error('CSS3 transforms are not supported');
                        }
                    });

                    window.addEventListener('resize', this.screenInit, false);
                    this.screenInit();
                };

                Plugin.prototype.screenInit = function () {
                    container.style.height = container.clientWidth+'px';
                };

                Plugin.prototype.animate = function (c, el, p, v, cb) {
                    var ms = 1,  //1=10ms
                        style = el.style,
                        initStyle = null,
                        g = parseInt(v)/c,
                        z = 0;
                    

                    animation = setInterval(function(){
                        var rvalue = null,
                            scvalue = null;
                        if (style['transform'] !== undefined) {
                            initStyle = style.transform.match(/\(.{1,6}\)/g);
                        } else if (style['webkitTransform'] !== undefined) {
                            initStyle = style.webkitTransform.match(/\(.{1,6}\)/g);
                        } else if (style['MozTransform'] !== undefined) {
                            initStyle = style.MozTransform.match(/\(.{1,6}\)/g);
                        } else if (style['msTransform'] !== undefined) {
                            initStyle = style.msTransform.match(/\(.{1,6}\)/g);
                        } else {
                            throw new Error('CSS3 transforms are not supported');
                        }
                        for(var i=0;i<initStyle.length;i+=1){
                            if(initStyle[i].indexOf('deg')!=-1){
                                rvalue = parseInt(initStyle[i].replace(/([^0-9]+)/g, ''));
                            } else {
                                scvalue = parseInt(initStyle[i].replace(/([^0-9]+)/g, '')[0]);
                            }
                        }
                       
                        if (ms<=c) {
                            if(p=='rotate'){
                                z = parseInt(g) + rvalue;
                            }
                            if (style['transform'] !== undefined) {
                                style['transform'] = 'rotate('+z+'deg) scale('+scvalue+', '+scvalue+')'
                            } else if (style['webkitTransform'] !== undefined) {
                                style['webkitTransform'] = 'rotate('+z+'deg) scale('+scvalue+', '+scvalue+')'
                            } else if (style['MozTransform'] !== undefined) {
                                style['MozTransform'] = 'rotate('+z+'deg) scale('+scvalue+', '+scvalue+')'
                            } else if (style['msTransform'] !== undefined) {
                                style['msTransform'] = 'rotate('+z+'deg) scale('+scvalue+', '+scvalue+')'
                            } else {
                                throw new Error('CSS3 transforms are not supported');
                            }
                        } else {
                            clearInterval(animation);
                            if(cb && typeof(cb) === "function") {
                                cb();
                            }
                        }
                        ms+=1;
                    }, 10)
                };//-webkit-transform: rotate(180deg) scale(1, 1);

                Plugin.prototype.clickHandler = function (event) {
                    event.preventDefault();
                    var nvalue = null,
                        bitem = null,
                        holderrot = '',
                        erot = '',
                        numBtns = null;
                    if(event.target.nodeName.toLowerCase()=="span"){
                        nvalue = event.target.parentNode.dataset.next;
                    } else {
                        nvalue = event.target.dataset.next;
                    }
                    switch(nvalue){
                        case 'll': holderrot = '90'; erot = '-90'
                            break;
                        case 'gl': holderrot = '180'; erot = '180'
                            break;
                        case 'cl': holderrot = '0'; erot = '0'
                            break;
                        case 'sl': holderrot = '-90'; erot = '90'
                            break;
                        case 'nl': holderrot = '180'; erot = '180'
                            break;
                        case 'pl': holderrot = '0'; erot = '0'
                            break;
                    }
                    /*numBtns = $('.cpin_button span').length;
                    $.each($('.cpin_button span'), function(index, val) {
                        Plugin.prototype.animate(15, val, 'rotate', '90', function(){
                            console.info('callback')
                            Plugin.prototype.setPinBoard(nvalue);
                        )
                    });}*/
                    /*$('.cpin_button span').css({rotate:erot}).animate({ scale:0}, 150, function(){
                        if( --numBtns > 0 ) return;
                        $(holder).animate({rotate:holderrot}, {
                            duration: 150,
                            complete:function(){
                                //Plugin.prototype.setPinBoard(nvalue);
                            }
                        });
                        Plugin.prototype.animate(15, function(){console.info('n'); Plugin.prototype.setPinBoard(nvalue);})
                    });*/
                    $(holder).removeClass('ll gl cl sl nl pl').addClass(nvalue);
                    
                };

                Plugin.prototype.setPinBoard = function (selectedkey) {
                    var buttons = document.getElementsByClassName('cpin_button');
                    labels = symbols[selectedkey].sort(shuffle);
                    for(var i=0; i<buttons.length; i+=1){
                        var b = buttons[i],
                            s = $(b).find('span')[0];
                        if (selectedkey=='cl') {
                            s.style.backgroundColor = '#'+labels[i].value;
                            s.innerHTML = '';
                        } else {
                            s.style.backgroundColor = '';
                            s.innerHTML = labels[i].value;
                        }
                        b.dataset.next = labels[i].next;
                    }
                    $('.cpin_button span').animate({scale:1}, {
                        duration: 150
                    });
                };

                $.fn[pluginName] = function (options) {
                    return this.each(function () {
                        if (!$.data(this, 'plugin_' + pluginName)) {
                            $.data(this, 'plugin_' + pluginName, 
                            new Plugin( this, options ));
                        }
                    });
                }
            })( jQuery, window, document );



        </script>
    </body>
</html>