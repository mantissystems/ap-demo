
dashy({
    appendTo: 'dashboard',
    //menu: true,
    locale: window.locale,
    items: [{
        name: 'Cloud apps',
        children: [
//            { title: 'New Comment', url: '/nl/comment_new', icon: 'cloud-download', color: 'red' },
//            { title: 'New Post', url: '/nl/admin/post/new', icon: 'bar-chart', color: 'orange' },
        ]
    }, {
        name: 'Maintenance apps',
        children: [
            { title: 'Applicatie', url: '/nl/blog', icon: 'plug', color: 'orange' },
            { title: 'Beheerpaneel', url: '/nl/admin/post', icon: 'list', color: 'lightgreen' }
        ]
    }, {
        name: 'Data maintenance',
        children: [
//            { title: '', url: '/nl/blog', icon: 'cogs', color: 'green' },
//            { title: '', url: '/nl/blog', icon: 'cloud', color: 'blue' },
            { title: 'Logout', url: '/nl/logout', icon: 'arrow-down', color: 'indigo' },
        ]
    }, {
        name: 'Registration',
        children: [
            { title: 'Login', url: '/nl/login', icon: 'arrow-up', color: 'purple' }
        ]
    }]
});
//dashy({
//    appendTo: 'dashboard2',
//    //menu: true,
//    items: [{
//        name: 'Cloud apps',
//        children: [
//            { title: 'Candidates', url: 'createCandidates', icon: 'drivers-license-o', color: 'red' },
//            { title: 'Standby List', url: 'createStandbyList', icon: 'chrome', color: 'orange' }
//        ]
//    }, {
//        name: 'Maintenance apps',
//        children: [
//            { title: 'Administration', url: 'Admin', icon: 'plug', color: 'orange' },
//            { title: 'Plan Helpers', url: 'PlanHelpers', icon: 'dashboard', color: 'blue' }
//        ]
//    }, {
//        name: 'Data maintenance',
//        children: [
//            { title: 'Adapter setup', url: 'mapping_edit', icon: 'cogs', color: 'green' },
//            { title: 'Cloud setup', url: 'ClubActions', icon: 'cloud', color: 'blue' },
//            { title: 'My actions', url: '/clubaction/2', icon: 'compress', color: 'indigo' },
//        ]
//    }, {
//        name: 'Registration',
//        children: [
//            { title: 'All actions', url: '/clubaction/1', icon: 'commenting', color: 'purple' }
//        ]
//    }]
//});
