class Profile_Menu{
    constructor(){
        
    }
    
    get_body(page){
        let nav_page = {page: page};

        // $.post("/app/src/bids/receive.php", nav_page, function(result){
        //     const _profilemenu = new Profile_Menu();

        //     _profilemenu.report_status($.trim(result));
        // });
    }
    
    change_activemenu(_this){
        $(".profile-menu.active")
        .removeClass('active')
        .addClass('text-white'); // remove active and add text-white
        
        $(_this).addClass('active'); // add active to the active menu
        alert('1');jkljkjk
    }
    
    show_body(){
        const _profilemenu = new Profile_Menu();
        
        $(".profile-menu").click(function(){
           let nav_page = $.trim($(this).text());
           
           $('.page-title').html(nav_page); // change page title
           
           _profilemenu.change_activemenu(this); // change active menu
           
           _profilemenu.get_body(nav_page); // display the body of the menu
        });
    }
}