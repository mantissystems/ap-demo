
dashy({
    appendTo: 'dashboard',
    //menu: true,
    locale: window.locale,
    items: [{
        name: 'Cloud apps',
        children: [
            { title: 'Available', url: 'available', icon: 'cloud-download', color: 'red' },
            { title: 'Graph after inload', url: 'Graph', icon: 'bar-chart', color: 'orange' }
        ]
    }, {
        name: 'Maintenance apps',
        children: [
            { title: 'Load adapter data', url: 'Import', icon: 'plug', color: 'orange' },
            { title: 'Schedule calendar', url: 'ScheduleCal', icon: 'list', color: 'lightgreen' }
        ]
    }, {
        name: 'Data maintenance',
        children: [
            { title: 'Adapter setup', url: 'mapping_edit', icon: 'cogs', color: 'green' },
            { title: 'Cloud setup', url: '', icon: 'cloud', color: 'blue' },
            { title: 'Mapping equipment', url: 'mapping_edit', icon: 'compress', color: 'indigo' },
        ]
    }, {
        name: 'Registration',
        children: [
            { title: 'Update ClubAction from Calendar', url: 'UpdateClubAction', icon: 'arrow-up', color: 'purple' }
        ]
    }]
});
dashy({
    appendTo: 'dashboard2',
    //menu: true,
    items: [{
        name: 'Cloud apps',
        children: [
            { title: 'Candidates', url: 'createCandidates', icon: 'drivers-license-o', color: 'red' },
            { title: 'Standby List', url: 'createStandbyList', icon: 'chrome', color: 'orange' }
        ]
    }, {
        name: 'Maintenance apps',
        children: [
            { title: 'Administration', url: 'Admin', icon: 'plug', color: 'orange' },
            { title: 'Plan Helpers', url: 'PlanHelpers', icon: 'dashboard', color: 'blue' }
        ]
    }, {
        name: 'Data maintenance',
        children: [
            { title: 'Adapter setup', url: 'mapping_edit', icon: 'cogs', color: 'green' },
            { title: 'Cloud setup', url: 'ClubActions', icon: 'cloud', color: 'blue' },
            { title: 'My actions', url: '/clubaction/2', icon: 'compress', color: 'indigo' },
        ]
    }, {
        name: 'Registration',
        children: [
            { title: 'All actions', url: '/clubaction/1', icon: 'commenting', color: 'purple' }
        ]
    }]
});
