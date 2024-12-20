
var basepath2=$('#txtRootUrl').val();
if(localStorage.getItem("color")){
        $("#color" ).attr("href", basepath2+"assets/css/"+localStorage.getItem("color")+".css" );
}
if(localStorage.getItem("dark")){
    $("body").attr("class", localStorage.getItem("dark"));
}


(function() {
})();
$('<div class="customizer-contain">  <div class="customizer-header"> <i class="icon-close icons"></i> </div>  <div class="customizer-links"> <div class="nav nac-pills" id="c-pills-tab" role="tablist" aria-orientation="vertical"> <a class="nav-link active show" id="c-pills-home-tab" data-toggle="pill" href="#c-pills-home" role="tab" aria-controls="c-pills-home" aria-selected="true"> <div class="settings"> <i class="icofont icofont-ui-settings"></i> General setting <\/div></a> <a class="nav-link" id="c-pills-profile-tab" data-toggle="pill" href="#c-pills-profile" role="tab" aria-controls="c-pills-profile" aria-selected="false"> <div class="settings color-settings"> <i class="icofont icofont-color-bucket"></i> Colors </div></a></div></div><div class="tab-content" id="c-pills-tabContent"> <div class="customizer-body custom-scrollbar"> <div class="tab-pane fade show active" id="c-pills-home" role="tabpanel" aria-labelledby="c-pills-home-tab"> <!--<h6>Layout Type</h6> <ul class="main-layout layout-grid"> <li data-attr="ltr" class="active"> <div class="body"> <ul> <li class="body"> <span class="badge badge-light">LTR</span> <\/li></ul> <\/div><\/li><li data-attr="rtl"> <div class="body"> <ul> <li class="body"> <span class="badge badge-light">RTL</span><\/li></ul> </div></li><li data-attr="box-layout" class="box-layout"> <div class="body"> <ul> <li class="body"> <span class="badge badge-light">Box</span> <\/li></ul></div></li></ul> --><h6 class="">Sidebar Type</h6><ul class="sidebar-type layout-grid"> <li data-attr="normal-sidebar"> <div class="header bg-light"> <ul> <li><\/li><li><\/li><li><\/li></ul></div><div class="body"> <ul> <li class="bg-dark sidebar"><\/li><li class="bg-light body w-100"> </li></ul></div></li><li data-attr="compact-sidebar"> <div class="header bg-light"> <ul> <li><\/li><li><\/li><li><\/li></ul></div><div class="body"> <ul> <li class="bg-dark sidebar compact"><\/li><li class="bg-light body"> </li></ul></div></li></ul><h6 class="display-none">Sidebar background setting</h6><ul class="nav nac-pills display-none" id="pills-tab" role="tablist"> <li class="nav-item"><a class="nav-link active show" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true" data-original-title="" title="">Color</a><\/li><li class="nav-item"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" data-original-title="" title="">Pattern</a><\/li><li class="nav-item"><a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false" data-original-title="" title="">image</a></li></ul><div class="tab-content sidebar-main-bg-setting display-none" id="pills-tabContent"> <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"> <ul class="sidebar-bg-settings"> <li class="bg-color  bg-dark active" data-attr="dark-sidebar"> <\/li><li class="bg-color bg-white" data-attr="light-sidebar"> <\/li><li class="bg-color bg-color1" data-attr="color1-sidebar"> <\/li><li class="bg-color bg-color2" data-attr="color2-sidebar"> <\/li><li class="bg-color bg-color3" data-attr="color3-sidebar"> <\/li><li class="bg-color bg-color4" data-attr="color4-sidebar"> <\/li><li class="bg-color bg-color5" data-attr="color5-sidebar"> <\/li></ul></div><div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"> <ul class="sidebar-bg-settings"> <li class="bg-pattern bg-pattern1" data-attr="sidebar-pattern1"> <\/li><li class="bg-pattern bg-pattern2" data-attr="sidebar-pattern2"> <\/li><li class="bg-pattern bg-pattern3" data-attr="sidebar-pattern3"> <\/li><li class="bg-pattern bg-pattern4" data-attr="sidebar-pattern4"> <\/li><li class="bg-pattern bg-pattern5" data-attr="sidebar-pattern5"> <\/li><li class="bg-pattern bg-pattern6" data-attr="sidebar-pattern6"> <\/li></ul></div><div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"> <ul class="sidebar-bg-settings"> <li class="bg-img bg-img1" data-attr="sidebar-img1"> <\/li><li class="bg-img bg-img2" data-attr="sidebar-img2"> <\/li><li class="bg-img bg-img3" data-attr="sidebar-img3"> <\/li><li class="bg-img bg-img4" data-attr="sidebar-img4"> <\/li><li class="bg-img bg-img5" data-attr="sidebar-img5"> <\/li><li class="bg-img bg-img6" data-attr="sidebar-img6"> <\/li></ul></div></div></div><div class="tab-pane fade " id="c-pills-profile" role="tabpanel" aria-labelledby="c-pills-profile-tab"> <h6>Light layout</h6> <ul class="layout-grid customizer-color"> <li class="color-layout" data-attr="color-1" data-primary="#158df7" data-secondary="#fb2e63"> <div><\/div><\/li><li class="color-layout" data-attr="color-2" data-primary="#0288d1" data-secondary="#26c6da"> <div><\/div><\/li><li class="color-layout" data-attr="color-3" data-primary="#d64dcf" data-secondary="#8e24aa"> <div><\/div><\/li><li class="color-layout" data-attr="color-4" data-primary="#4c2fbf" data-secondary="#2e9de4"> <div><\/div><\/li><li class="color-layout" data-attr="color-5" data-primary="#7c4dff" data-secondary="#7b1fa2"> <div><\/div><\/li><li class="color-layout" data-attr="color-6" data-primary="#3949ab" data-secondary="#4fc3f7"> <div><\/div></li></ul><h6 class="">Dark Layout</h6><ul class="layout-grid customizer-color dark"> <li class="color-layout" data-attr="color-1" data-primary="#4466f2" data-secondary="#1ea6ec"> <div></div></li><li class="color-layout" data-attr="color-2" data-primary="#0288d1" data-secondary="#26c6da"> <div></div></li><li class="color-layout" data-attr="color-3" data-primary="#d64dcf" data-secondary="#8e24aa"> <div></div></li><li class="color-layout" data-attr="color-4" data-primary="#4c2fbf" data-secondary="#2e9de4"> <div></div></li><li class="color-layout" data-attr="color-5" data-primary="#7c4dff" data-secondary="#7b1fa2"> <div></div></li><li class="color-layout" data-attr="color-6" data-primary="#3949ab" data-secondary="#4fc3f7"> <div></div></li></ul><h6 class="">Mix Layout</h6><ul class="layout-grid customizer-mix"> <li class="color-layout active" data-attr="light-only"> <div class="header bg-light"> <ul> <li><\/li><li><\/li><li><\/li></ul></div><div class="body"> <ul> <li class="bg-light sidebar"><\/li><li class="bg-light body"> </li></ul></div></li><!-- <li class="color-layout" data-attr="dark-sidebar"> <div class="header bg-light"> <ul> <li><\/li><li><\/li><li><\/li></ul></div><div class="body"> <ul> <li class="bg-dark sidebar"><\/li><li class="bg-light body"> </li></ul></div></li><li class="color-layout" data-attr="dark-body-only"> <div class="header bg-light"> <ul> <li><\/li><li><\/li><li><\/li></ul></div><div class="body"> <ul> <li class="bg-light sidebar"><\/li><li class="bg-dark body"> </li></ul></div></li><li class="color-layout" data-attr="dark-sidebar-body-mix"> <div class="header bg-light"> <ul> <li><\/li><li><\/li><li><\/li></ul></div><div class="body"> <ul> <li class="bg-dark sidebar"><\/li><li class="bg-dark body"> </li></ul></div></li><li class="color-layout" data-attr="dark-header-sidebar-mix"> <div class="header bg-dark"> <ul> <li><\/li><li><\/li><li><\/li></ul></div><div class="body"> <ul> <li class="bg-dark sidebar"><\/li><li class="bg-light body"> </li></ul></div></li>--> <li class="color-layout" data-attr="dark-only"> <div class="header bg-dark"> <ul> <li><\/li><li><\/li><li><\/li></ul></div><div class="body"> <ul> <li class="bg-dark sidebar"><\/li><li class="bg-dark body"> </li></ul></div></li></ul></div></div></div></div>').appendTo($('body'));
//live customizer js
$(document).ready(function() {
    const postData=async(methods="post", data = {},headers=null)=>{
        let RootUrl=$('#txtRootUrl').val();
        let url=RootUrl+"Set/Theme/Update";
        $.ajax({
            type:methods,
            url:url,
            async:false,
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            data:{Theme:JSON.stringify(data) },
            success:function(response){
            }
        });
    };
    $('.customizer-mix li.color-layout.active').removeClass('active')
    $("[data-attr="+localStorage.getItem("body")+"]").addClass('active')

    $('.main-layout li.active').removeClass('active')
    $("[data-attr="+localStorage.getItem("main-theme-layout")+"]").addClass('active')

    
    $(".theme-setting").click(function(){
        $(".customizer-contain").toggleClass("open");
        $(".customizer-links").toggleClass("open");
    });

    $(".close-customizer-btn").on('click', function() {
        $(".floated-customizer-panel").removeClass("active");
    });

    $(".customizer-contain .icon-close").on('click', function() {
        $(".customizer-contain").removeClass("open");
        $(".customizer-links").removeClass("open");
    });

    $(".customizer-color li").on('click', async function() {
        $(".customizer-color li").removeClass('active');
        $(this).addClass("active");
        var color = $(this).attr("data-attr");
        var primary = $(this).attr("data-primary"); 
        var secondary = $(this).attr("data-secondary");
        localStorage.setItem("color", color);
        localStorage.setItem("primary", primary);
        localStorage.setItem("secondary", secondary);
        localStorage.removeItem("dark");
        await postData("post",{color:color,primary:primary,secondary:secondary});
        $("#color" ).attr("href", basepath2+"assets/css/"+color+".css" );
        $(".dark-only").removeClass('dark-only');
        location.reload(true);
    });

    $(".customizer-color.dark li").on('click', async function() {
        $(".customizer-color.dark li").removeClass('active');
        $(this).addClass("active");
        $("body").attr("class", "dark-only");
        localStorage.setItem("dark", "dark-only");
    });


    $(".customizer-mix li").on('click', async function() {
        $(".customizer-mix li").removeClass('active');
        $(this).addClass("active");
        var mixLayout = $(this).attr("data-attr");
        if(mixLayout!=undefined){
            $("body").attr("class", mixLayout);
            localStorage.setItem("body", mixLayout);
            let dark=undefined;
            postData("post",{body:mixLayout,dark:mixLayout});
        }
    });


    $('.sidebar-setting li').on('click', function() {
        $(".sidebar-setting li").removeClass('active');
        $(this).addClass("active");
        var sidebar = $(this).attr("data-attr");
        $(".page-sidebar").attr("sidebar-layout",sidebar);
    });

    $('.sidebar-main-bg-setting li').on('click', async function() {
        let bgtype="bg-color";
        if($(this).hasClass("bg-pattern")){
            bgtype="bg-pattern";
        }else if($(this).hasClass("bg-img")){
            bgtype="bg-img";
        }
        $(".sidebar-main-bg-setting li").removeClass('active')
        $(this).addClass("active")
        var bg = $(this).attr("data-attr");
        $("body").attr("class", "page-sidebar "+bg);
        localStorage.setItem("sidebar-layout", "page-sidebar "+bg);
        localStorage.setItem("sidebar-bg-type", bgtype);
        await postData("post",{"sidebar-layout":"page-sidebar "+bg,"sidebar-bg-type":bgtype});
    });

    $('.sidebar-type li').on('click', async function () {
        // $(".sidebar-type li").removeClass('active');
        var type = $(this).attr("data-attr");
        if(type=='compact-sidebar'){
            await postData("post",{"page-wrapper":'compact-wrapper',"page-body-wrapper":'sidebar-icon'});
        }else if(type=='normal-sidebar'){
            await postData("post",{"page-wrapper":'horizontal-wrapper',"page-body-wrapper":'horizontal-menu'});
        }
        var boxed = "";
        if($(".page-wrapper").hasClass("box-layout")){
            boxed = "box-layout";
        }
        switch (type) {
            case 'compact-sidebar':
            {
                    $(".page-wrapper").attr("class", "page-wrapper compact-wrapper "+boxed);
                    $(".page-body-wrapper").attr("class", "page-body-wrapper sidebar-icon");
                    localStorage.setItem('page-wrapper', 'compact-wrapper');
                    localStorage.setItem('page-body-wrapper', 'sidebar-icon');
                    
                    break;
            }
            case 'normal-sidebar':
            {
                
                $(".page-wrapper").attr("class", "page-wrapper horizontal-wrapper "+boxed);
                $(".page-body-wrapper").attr("class", "page-body-wrapper horizontal-menu");
                $(".logo-wrapper").find('img').attr('src', '../assets/images/logo/logo.png');
                localStorage.setItem('page-wrapper', 'horizontal-wrapper');
                localStorage.setItem('page-body-wrapper', 'horizontal-menu');
                
                break;
            }
        }
        // $(this).addClass("active");
        location.reload(true);
    });

    $('.main-layout li').on('click', async function() {
        $(".main-layout li").removeClass('active');
        $(this).addClass("active");
        var layout = $(this).attr("data-attr");
        $("body").attr("main-theme-layout", layout);
        $("html").attr("dir", layout);
        localStorage.setItem('main-theme-layout', layout);
        localStorage.setItem('html', layout);
        await postData("post",{"main-theme-layout":layout,"html":layout});
    });

    $('.main-layout .box-layout').on('click', async function() {
        $(".main-layout .box-layout").removeClass('active');
        $(this).addClass("active");
        var layout = $(this).attr("data-attr");
        $("body").attr("main-theme-layout", layout);
        $("html").attr("dir", layout);
        localStorage.setItem('main-theme-layout', layout);
        localStorage.setItem('html', layout);
        await postData("post",{"main-theme-layout":layout,"html":layout});
    });

});
