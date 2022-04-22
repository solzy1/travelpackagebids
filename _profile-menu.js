class Profile_Menu{
    constructor(){
        
    }
    
    change_activemenu(_this){
        $(".profile-menu.active")
        .removeClass('active')
        .addClass('text-white'); // remove active and add text-white
        
        $(_this).addClass('active'); // add active to the active menu
    }
    
    show_body(){
        const _profilemenu = new Profile_Menu();

        // $(".profile-menu").click(function(){
        let nav_page = _profilemenu.get_page();

        $('.page-title').html(nav_page); // change page title

        let active_menu = ".profile-menu:contains('"+nav_page+"')";
        _profilemenu.change_activemenu(active_menu); // change active menu
    }

    get_page(){
        let on_profilepage = $('.user-profile'); // profile page
        let on_packagespage = $('#create-a-package'); // packages page
        // ADMIN
        let page = $.trim($('#page-url').val());

        if(on_profilepage.length > 0)
            return 'My profile';
        else if(on_packagespage.length > 0)
            return 'My packages';
        else if (page=='packages')
            return 'Packages';
        else if (page=='travel_agents')
            return 'Travel agents';

        return;
    }
}