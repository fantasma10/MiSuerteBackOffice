//------------- main.js -------------//

// make console.log safe to use
window.console||(console={log:function(){}});

//Internet Explorer 10 in Windows 8 and Windows Phone 8 fix
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
  var msViewportStyle = document.createElement('style')
  msViewportStyle.appendChild(
    document.createTextNode(
      '@-ms-viewport{width:auto!important}'
    )
  )
  document.querySelector('head').appendChild(msViewportStyle)
}

//Android stock browser
var nua = navigator.userAgent
var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
if (isAndroid) {
  $('select.form-control').removeClass('form-control').css('width', '100%')
}

//attach fast click
window.addEventListener('load', function() {
//    FastClick.attach(document.body);
}, false);

//doc ready function
$(document).ready(function() {

    //Disable certain links
    $('a[href^=#]').click(function (e) {
        e.preventDefault()
    })

    //------------- Init our plugin -------------//
    $('body').supr({
        customScroll: {
            color: '#c4c4c4', //color of custom scroll
            rscolor: '#95A5A6', //color of right sidebar
            size: '5px', //size in pixels
            opacity: '1', //opacity
            alwaysVisible: false //disable hide in
        },
        header: {
            fixed: true, //fixed header
            shrink: true //shrink header on scroll ( only when fixed is true.)
        },
        breadcrumbs: {
            auto: true, //auto populate breadcrumbs via js if is false you need to provide own markup see for example.
            homeicon: 's16 icomoon-icon-screen-2', //home icon 
            dividerIcon: 's16 icomoon-icon-arrow-right-3' //divider icon
        },
        sidebar: {
            fixed: true,//fixed sidebar
            rememberToggle: true, //remember if sidebar is hided
            offCanvas: false //make sidebar offcanvas in tablet and small screens
        },
        rightSidebar: {
            fixed: true,//fixed sidebar
            rememberToggle: false//remember if sidebar is hided
        },
        sideNav : {
            toggleMode: true, //close previous open submenu before expand new
            showArrows: true,//show arrow to indicate sub
            sideNavArrowIcon: 'icomoon-icon-arrow-down-2 s16', //arrow icon for navigation
            subOpenSpeed: 200,//animation speed for open subs
            subCloseSpeed: 300,//animation speed for close subs
            animationEasing: 'linear',//animation easing
            absoluteUrl: false, //put true if use absolute path links. example http://www.host.com/dashboard instead of /dashboard
            subDir: '' //if you put template in sub dir you need to fill here. example '/html'
        },
        panels: {
            refreshIcon: 'brocco-icon-refresh s12',//refresh icon for panels
            toggleIcon: 'icomoon-icon-plus',//toggle icon for panels
            collapseIcon: 'icomoon-icon-minus',//colapse icon for panels
            closeIcon: 'icomoon-icon-close', //close icon
            showControlsOnHover: false,//Show controls only on hover.
            loadingEffect: 'rotateplane',//loading effect for panels. bounce, none, rotateplane, stretch, orbit, roundBounce, win8, win8_linear, ios, facebook, rotation, pulse.
            loaderColor: '#616469',
            rememberSortablePosition: true //remember panel position
        },
        accordion: {
            toggleIcon: 'icomoon-icon-minus s12',//toggle icon for accrodion
            collapseIcon: 'icomoon-icon-plus s12'//collapse icon for accrodion
        },
        tables: {
            responsive: true, //make tables resposnive
            customscroll: true //ativate custom scroll for responsive tables
        },
        alerts: {
            animation: true, //animation effect toggle
            closeEffect: 'bounceOutDown' //close effect for alerts see http://daneden.github.io/animate.css/
        },
        dropdownMenu: {
            animation: true, //animation effect for dropdown
            openEffect: 'fadeIn',//open effect for menu see http://daneden.github.io/animate.css/
        },
        backToTop: true //back to top
    });

    //------------- Bootstrap tooltips -------------//
    $("[data-toggle=tooltip]").tooltip ({container:'body'});
    $(".tip").tooltip ({placement: 'top', container: 'body'});
    $(".tipR").tooltip ({placement: 'right', container: 'body'});
    $(".tipB").tooltip ({placement: 'bottom', container: 'body'});
    $(".tipL").tooltip ({placement: 'left', container: 'body'});
    //------------- Bootstrap popovers -------------//
    $("[data-toggle=popover]").popover ({
        html: true
    });

    //get plugin object 
    var adminObj = $('body').data('supr');
    //now we have access to change settings.

    //If new user set the localstorage variables
    if ( firstImpression() ) {
        //console.log('New user');
        if (adminObj.settings.header.fixed) {
            store.set('fixed-header', 1);
        } else {store.set('fixed-header', 0);}
        if (adminObj.settings.sidebar.fixed) {
            store.set('fixed-left-sidebar', 1);
        } else {store.set('fixed-left-sidebar', 0);}
        if (adminObj.settings.rightSidebar.fixed) {
            store.set('fixed-right-sidebar', 1);
        } else {store.set('fixed-right-sidebar', 0);}
    } 
});
