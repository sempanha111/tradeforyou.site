$(document).ready(function(){
	$(".dropdown img.flag").addClass("flagvisibility");

    $(".dropdown dt a").click(function() {
        $(".dropdown dd ul").toggle();
    });

    $(".dropdown dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdown dt a").html(text);
        $(".dropdown dd ul").hide();
    });
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("dropdown"))
            $(".dropdown dd ul").hide();
    });



	  //calculator1//




	// function calc(){
	//     var percent 	= [10];
	// 	var minMoney 	= [0.001];
	// 	var maxMoney	= [600];

	// 	if($("#amount").val().length == 0){
	// 		$("#amount").val(minMoney[0]);
	// 	}

	// 	amount = parseFloat($("#amount").val());
	// 	id = -1;
	// 	var length = percent.length;
	// 	var i = 0;
	// 	do {
	// 		if(minMoney[i] <= amount && amount <= maxMoney[i]){
	// 			id = i;
	// 			i = i + length;
	// 		}
	// 		i++
	// 	}
	// 	while(i < length)

	// 	if(id != -1){
	// 		profitDaily = amount / 100 * percent[id];
	// 		profitDaily = profitDaily.toFixed(6);
	// 		profitHourly = amount / 100 * percent[id];
	// 		profitHourly = profitHourly.toFixed(6);
	// 		profitTotal = profitDaily * 12;
	// 		profitTotal = profitTotal.toFixed(6);
	// 		profitMonthly = profitDaily * 30;
	// 		profitMonthly = profitMonthly.toFixed(6);


	// 		if(amount < minMoney[id] || isNaN(amount) == true){
	// 			$("#profitHourly").text("Error!");
	// 			$("#profitDaily").text("Error!");
	// 			$("#profitTotal").text("Error!");
	// 			$("#profitMonthly").text("Error!");
	// 		} else {
	// 			$("#profitHourly").text("Ƀ" + profitHourly);
	// 			$("#profitDaily").text("Ƀ" + profitDaily);
	// 			$("#profitTotal").text("Ƀ" + profitTotal);
	// 			$("#profitMonthly").text("Ƀ" + profitMonthly);
	// 		}
	// 	} else {
	// 		$("#profitHourly").text("Error!");
	// 		$("#profitDaily").text("Error!");
	// 		$("#profitTotal").text("Error!");
	// 		$("#profitMonthly").text("Error!");
	// 	}
	// }

	// calc();

	// $("#amount").keyup(function(){
	// 	calc();
	// });



      //calculator2//

	//Calculator
	// function calc1(){
	// 	var percent 	= [700];
	// 	var minMoney 	= [0.001];
	// 	var maxMoney	= [600];

	// 	if($("#amount1").val().length == 0){
	// 		$("#amount1").val(minMoney[0]);
	// 	}

	// 	amount = parseFloat($("#amount1").val());
	// 	id = -1;
	// 	var length = percent.length;
	// 	var i = 0;
	// 	do {
	// 		if(minMoney[i] <= amount && amount <= maxMoney[i]){
	// 			id = i;
	// 			i = i + length;
	// 		}
	// 		i++
	// 	}
	// 	while(i < length)

	// 	if(id != -1){
	// 		profitDaily1 = amount / 100 * percent[id];
	// 		profitDaily1 = profitDaily1.toFixed(6);
	// 		profitHourly = amount / 100 * percent[id];
	// 		profitHourly = profitHourly.toFixed(6);
	// 		profitTotal1 = profitDaily1 * 13;
	// 		profitTotal1 = profitTotal1.toFixed(6);
	// 		profitMonthly1 = profitDaily1 * 30;
	// 		profitMonthly1 = profitMonthly1.toFixed(6);


	// 		if(amount < minMoney[id] || isNaN(amount) == true){
	// 			$("#profitHourly").text("Error!");
	// 			$("#profitDaily1").text("Error!");
	// 			$("#profitTotal1").text("Error!");
	// 			$("#profitMonthly1").text("Error!");
	// 		} else {
	// 			$("#profitHourly").text("Ƀ" + profitHourly);
	// 			$("#profitDaily1").text("Ƀ" + profitDaily1);
	// 			$("#profitTotal1").text("Ƀ" + profitTotal1);
	// 			$("#profitMonthly1").text("Ƀ" + profitMonthly1);
	// 		}
	// 	} else {
	// 		$("#profitHourly").text("Error!");
	// 		$("#profitDaily1").text("Error!");
	// 		$("#profitTotal1").text("Error!");
	// 		$("#profitMonthly1").text("Error!");
	// 	}
	// }

	// calc1();

	// $("#amount1").keyup(function(){
	// 	calc1();
	// });

       //calculator3//



	//Calculator
	// function calc2(){
	// 	var percent 	= [2000];
	// 	var minMoney 	= [0.001];
	// 	var maxMoney	= [600];

	// 	if($("#amount2").val().length == 0){
	// 		$("#amount2").val(minMoney[0]);
	// 	}

	// 	amount = parseFloat($("#amount2").val());
	// 	id = -1;
	// 	var length = percent.length;
	// 	var i = 0;
	// 	do {
	// 		if(minMoney[i] <= amount && amount <= maxMoney[i]){
	// 			id = i;
	// 			i = i + length;
	// 		}
	// 		i++
	// 	}
	// 	while(i < length)

	// 	if(id != -1){
	// 		profitDaily2 = amount / 100 * percent[id];
	// 		profitDaily2 = profitDaily2.toFixed(6);
	// 		profitHourly = amount / 100 * percent[id];
	// 		profitHourly = profitHourly.toFixed(6);
	// 		profitTotal2 = profitDaily2 * 13;
	// 		profitTotal2 = profitTotal2.toFixed(6);
	// 		profitMonthly2 = profitDaily2 * 30;
	// 		profitMonthly2 = profitMonthly2.toFixed(6);


	// 		if(amount < minMoney[id] || isNaN(amount) == true){
	// 			$("#profitHourly").text("Error!");
	// 			$("#profitDaily2").text("Error!");
	// 			$("#profitTotal2").text("Error!");
	// 			$("#profitMonthly2").text("Error!");
	// 		} else {
	// 			$("#profitHourly").text("Ƀ" + profitHourly);
	// 			$("#profitDaily2").text("Ƀ" + profitDaily2);
	// 			$("#profitTotal2").text("Ƀ" + profitTotal2);
	// 			$("#profitMonthly2").text("Ƀ" + profitMonthly2);
	// 		}
	// 	} else {
	// 		$("#profitHourly").text("Error!");
	// 		$("#profitDaily2").text("Error!");
	// 		$("#profitTotal2").text("Error!");
	// 		$("#profitMonthly2").text("Error!");
	// 	}
	// }

	// calc2();

	// $("#amount2").keyup(function(){
	// 	calc2();
	// });



});
