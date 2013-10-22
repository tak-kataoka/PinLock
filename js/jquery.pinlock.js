;(function($, window, document, undefined) {
    "use strict"

    var pluginName = 'pinLock',
        defaults = {

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

        window.addEventListener('resize', this.screenInit, false);
        this.screenInit();
    };

    Plugin.prototype.screenInit = function () {
        container.style.height = container.clientWidth+'px';
    };

    Plugin.prototype.clickHandler = function (event) {
        event.preventDefault();
        var nvalue = null,
            er = null,
            hr = null,
            numBtns = null;
        if(event.target.nodeName.toLowerCase()=="span"){
            nvalue = event.target.parentNode.dataset.next;
        } else {
            nvalue = event.target.dataset.next;
        }
        switch(nvalue){
            case 'll': er = '90'; hr = '-90';
                break;
            case 'gl': er = '180'; hr = '180';
                break;
            case 'cl': er = '-90'; hr = '90';
                break;
            case 'sl': er = '-90'; hr = '90';
                break;
            case 'nl': er = '180'; hr = '180';
                break;
            case 'pl': er = '0'; hr = '0';
                break;
        }
        numBtns = $('.cpin_button span').length;
        $('.cpin_button span').transition({ scale: 0 },150, function(){
        	if( --numBtns > 0 ) {return;}
        	$(holder).transition({ rotate: er }, 150, function(){
        		$('.cpin_button span').css({rotate: hr});
	        	Plugin.prototype.setPinBoard(nvalue);
	        })
        });
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
        $('.cpin_button span').transition({ scale: 1 },150);
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