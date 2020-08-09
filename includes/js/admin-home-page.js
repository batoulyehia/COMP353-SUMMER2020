$(document).ready(function() {
    // all custom jQuery will go here

    $("input[type=radio][id=employeeList]").click(function(){
        $(".employeeList, .employeeListTitle").addClass("show");
        $(".employerList, .employerListTitle").removeClass("show");
        $(".postedJobs, .postedJobsTitle").removeClass("show");
        $(".appliedJobs, .appliedJobsTitle").removeClass("show");
        $(".offersGiven, .offersGivenTitle").removeClass("show");
    });

    $("input[type=radio][id=employerList]").click(function(){
        $(".employeeList, .employeeListTitle").removeClass("show");
        $(".employerList, .employerListTitle").addClass("show");
        $(".postedJobs, .postedJobsTitle").removeClass("show");
        $(".appliedJobs, .appliedJobsTitle").removeClass("show");
        $(".offersGiven, .offersGivenTitle").removeClass("show");
    });

    $("input[type=radio][id=postedJobs]").click(function(){
        $(".employeeList, .employeeListTitle").removeClass("show");
        $(".employerList, .employerListTitle").removeClass("show");
        $(".postedJobs, .postedJobsTitle").addClass("show");
        $(".appliedJobs, .appliedJobsTitle").removeClass("show");
        $(".offersGiven, .offersGivenTitle").removeClass("show");
    });

    $("input[type=radio][id=appliedJobs]").click(function(){
        $(".employeeList, .employeeListTitle").removeClass("show");
        $(".employerList, .employerListTitle").removeClass("show");
        $(".postedJobs, .postedJobsTitle").removeClass("show");
        $(".appliedJobs, .appliedJobsTitle").addClass("show");
        $(".offersGiven, .offersGivenTitle").removeClass("show");
    });


    $("input[type=radio][id=offersGiven]").click(function(){
        $(".employeeList, .employeeListTitle").removeClass("show");
        $(".employerList, .employerListTitle").removeClass("show");
        $(".postedJobs, .postedJobsTitle").removeClass("show");
        $(".appliedJobs, .appliedJobsTitle").removeClass("show");
        $(".offersGiven, .offersGivenTitle").addClass("show");
    });



});