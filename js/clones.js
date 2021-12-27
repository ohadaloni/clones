/*------------------------------------------------------------*/
$(function() {
	clonesPaintRows(document);
	/*	$(".imgToolTip").imgToolTip();	*/
	$(".showImage").showImage();
});
/*------------------------------------------------------------*/
function clonesPaintRows(context)
{
	$(".mRow", context).hoverClass("hilite");
	$(".clonesRow", context).hoverClass("hilite");
	$(".mFormRow", context).hoverClass("hilite");
	$(".mHeaderRow", context).addClass("clonesZebra0");
	$(".clonesHeaderRow", context).addClass("clonesZebra0");
	$(".mFormRow:nth-child(odd)", context).addClass("clonesZebra1");
	$(".mFormRow:nth-child(even)", context).addClass("clonesZebra2");
	$(".mRow:nth-child(odd)", context).addClass("clonesZebra1");
	$(".mRow:nth-child(even)", context).addClass("clonesZebra2");
	$(".clonesRow:nth-child(odd)", context).addClass("clonesZebra2");
	$(".clonesRow:nth-child(even)", context).addClass("clonesZebra1"); // first row is 1
	$(".clonesFormRow:nth-child(odd)", context).addClass("clonesZebra2");
	$(".clonesFormRow:nth-child(even)", context).addClass("clonesZebra1"); // first row is 1

	$(".today:nth-child(odd)", context).addClass("clonesZebra3");
	$(".today:nth-child(even)", context).addClass("clonesZebra4");
	$(".yesterday:nth-child(odd)", context).addClass("clonesZebra5");
	$(".yesterday:nth-child(even)", context).addClass("clonesZebra6");

}
/*------------------------------------------------------------*/
