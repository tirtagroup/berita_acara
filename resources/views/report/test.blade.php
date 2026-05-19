<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<div class="content je">
		<div class="pure-g ">
			<div class="pure-u-1-24 ">
			</div>
			<div class="pure-u-11-12">
				<h2 class="content-subhead">Journal Entries</h2>
			<!-- Journal Entry Section -->
				<div class="section-02">
					<div class="pure-g">
						<div class="pure-u-1-2">
							<label>Date:</label> 
							<input id="entree-date" type="date"required class="row-input-group date" name="date"  />
						</div>
						<div class="pure-u-1-2">
							<label>Entree ID:</label>
							<input id="entree-id" required class="row-input-group" name="id" type="text" readonly value="ENT-P-345" />
						</div>
					</div>
				</div>
				<div class="">
					<div class="pure-g">
						<!--<div class="pure-u-1-12"></div>-->
						<div class="pure-u-1-2">
							<table id="journal-entrees"  class="pure-table form-table">
								<thead>
									<tr>
										<th style="width:260px;">Account</th>
										<th >Debit</th>
										<th style="max-width:30px;">Credit</th>
										<th style="width:500px;">Memo</th> 
										<th style="width:50px;"></th>
									</tr>
								</thead>
							<!-----------newRow() function will append rows in here-------------------------->
								<tbody class="row-body">
									<tr class='entree-row'>
										<td>
											<select required class="row-input-group select_account" name="account_in" style="width:250px;">
												<option>
												</option>
											</select>
										</td>
										<td>
											<span class="cur_span"><i class="fa fa-usd" aria-hidden="true"></i></span>
											<input style="width:60px;  margin-left:20px;"  onkeyUp="update_in('debit_in');" step=".01"   name="debit_in" class="row-input-group"  type="number"  data-type="decimal" placeholder='0.00' />
										</td>
										<td>
											<span class="cur_span"><i class="fa fa-usd" aria-hidden="true"></i></span>
											<input style="width:60px;  margin-left:20px;" onkeyUp="update_in('credit_in')" name="credit_in" class="row-input-group"  type="number"  data-type="decimal" placeholder='0.00' />
										</td>
										<td>
											<input style="width:500px;"  name="memo_in" class="row-input-group" type="text"/>
										</td>
										<td>
											<button  tabindex = "-1" class="pure-button remove-btn  ">
												<i style="color:white;" class="fa fa-times" aria-hidden="true"></i>
											</button>
										</td>
									</tr>
									<tr class='entree-row'>
										<td>
											<select required class="row-input-group select_account" name="account_in" style="width:250px;">
												<option></option>
											</select>
										</td>
										<td>
											<span class="cur_span"><i class="fa fa-usd" aria-hidden="true"></i></span>
											<input style="width:60px;  margin-left:20px;"  onkeyUp="update_in('debit_in')" name="debit_in" class="row-input-group"  type="number" data-type="decimal" placeholder='0.00' />
										</td>
										<td>
											<span class="cur_span"><i class="fa fa-usd" aria-hidden="true"></i></span>
											<input style="width:60px;  margin-left:20px;" onkeyUp="update_in('credit_in')" name="credit_in" class="row-input-group" type="number" data-type="decimal" placeholder='0.00' />
										</td>
										<td>
											<input style="width:500px;"  name="memo_in" class="row-input-group" type="text"/>
										</td>
										<td>
											<button tabindex = "-1" class="pure-button remove-btn">
												<i style="color:white;" class="fa fa-times" aria-hidden="true"></i>
											</button>
										</td>
									</tr>
									<tr class="button-row">
										<td style="text-align:center; border-top:solid; border-width:1px;border-color:gray;" colspan="5"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>
									</tr>
								</tbody>
							<!---------------------------------------------------------------------->
								<thead>
									<tr>
										<td id="alert-msg" class="text-center" colspan="5"></td>
									</tr>
									<tr style="font-weight: 900;">
										<td style="width:260px; " class="text-center">Totals:</td>
										<td id="total_debit_in" style="width:30px;" class="text-center">$0.00</td>
										<td id="total_credit_in"  style="width:30px;" class="text-center">$0.00</td>
										<td style="width:500px;"></td>
										<td style="width:50px;"></td>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div class="section-03  pure-g">
					<div class="pure-u-1-2">
						<table id="" class="pure-table form-table">
						</table>
					</div>
				</div>
			</div>
			<div class="pure-u-1-24">
			</div>
		</div>
	</div>
	<div class="je">
		<div style="height:100px;" class=" je top center-block">
			<div class="pure-g ">
				<div class="center-block ">
					<br>
					<button type="button" style="width:92px;" onclick="saveEntree()">Save</button>
					<button style="width:92px;">Save & New</button>
					<button onclick="window.close();" type="reset" style="width:92px;">Cancel</button>				
				</div>
			</div>
		</div>
	</div>
<div id="response"></div>
<div hidden id="select_account"></div>
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

<style>
  select {
	height: 22px;
}

a {
	text-decoration: none;
	color: purple;
}
.login {
	width: 25%;
}

.bottom{
	position: absolute;
	bottom:0;
	left: 0;
}

.logout {
	position: absolute;;
	top:10px;
	right:10px;
}

.up-directory {
	position: absolute;;
	top:10px;
	left:12%;
}

.form-label {
	text-align: right;
}

.form-text{
	text-transform: capitalize;;
}

.column-center {
	border-left: 1px solid #EEE;
	/*border-right: 1px solid #EEE;*/
}

.column-right {
	border-left: 1px solid #EEE;
	/*border-right: 1px solid #EEE;*/
}

.general_padding {
	padding: 0 5px;
}

#ajax_msg{
	height: auto;
}

.suc_msg {
	padding: 3px 5px;
	/*height: 30px;*/
	border-style: solid;
	border-width: 1px;
	border-radius: 4px;
	border-color: #00B233;
	background-color: rgba(0,255,72,.3);
	color: #00B233;
}

.err_msg {
	padding: 3px 5px;
	/*height: 30px;*/
	border-style: solid;
	border-width: 1px;
	border-radius: 4px;
	border-color: #B20000;
	background-color: rgba(255,25,25,.3);
	color: #B20000;
}

/*Table styling/////////////////////////////////////////////////////////////////////////////////////////////////////*/
.invoice_table tr:nth-child(2n+0){
	background-color: rgba(31,141,214,0.1);
}

.invoice_table tr{
	height: 30px;
	font-size: 14px;
}

.invoice_table button{
	height: 20px;
	font-size: 11px;
	margin-top: auto;
	margin-bottom: auto;
}

/*Open Invoice Table styling/////////////////////////////////////////////////////////////////////////////////////////////////////*/

.openInvoice-list tr{
	font-size: 13px;
}

table.entity_list_table {
	border-collapse:collapse;
}

table.openInvoice-list th, table.openInvoice-list td {
	padding: 2px 15px 2px 15px;
	text-align: center;
}

table.openInvoice-list thead th {
	background-color:rgb(249,249,249);
}

table.openInvoice-list tfoot td {
	background-color:#ffccff;
}

table.openInvoice-list tbody tr{	
	border:1px solid rgba(0,0,0,.2);
	border-right-style: none;
	border-left-style: none;
}

table.openInvoice-list tr.tbody_header {
	font-weight:bold;
	text-align:center;
	background-color:#dddddd;
}

table.openInvoice-list a.pagelink {
	padding-left:5px;
	padding-right:5px;
	border:1px solid #666666;
	margin:0px 5px 0px 5px;
}

/*// Invoice Number */
.openInvoice-list th:first-child{
	width:80px;
}

/*// Date */
.openInvoice-list th:nth-child(2){
	width:100px;
}

/*// Days Aging */
.openInvoice-list th:nth-child(3){
	width:110px;
}

/*// Customer */
.openInvoice-list th:nth-child(4){
	width:190px;
}

/*// Invoice Total */
.openInvoice-list th:nth-child(5){
	width:120px;
}

/*// Amount Paid */
.openInvoice-list th:nth-child(6){
	width:120px;
}

/*// Open Balance */
.openInvoice-list th:nth-child(7){
	width:120px;
}

/*Form Styling ///////////////////////////////////////////////////////////////////////////////////////////////////////*/

.rate {
	width: 100%;
}

.qty {
	width:100%;
}

.total {
	width: 100%;
}


/* CSS for Journal Entrees */

.remove-btn {
	
	background:#CA5454;
	color:white;
}

.je .top, .je .bottom {
	
background:#191818;
	
}
.je tr:nth-child(even) {
	background: #f2f2f2
}

.je tr:nth-child(odd) {
	background: #FFF
}


/* toggles row when input is in focus */

.je tr.active {
	background: #C6EBF7
}

.je tr.button-row, .je tr.button-row button {
	background: #1f8dd6;
	color:white;
	font-size:105%;
}

.je .button-td {
	text-align: center;
	border: solid;
	border-width: 1px;
	border-color: gray;
}

.je table thead {
	border-bottom: solid;
	border-width: 1px;
	border-color: #909090;
}


/* ----- | padding | ----- */

.section-01 {
 	padding-left: 85px; 
	padding-right: 85px;
	padding-bottom: 15px;
	
}

.section-02 {
	padding-top: 15px;
 	/*padding-left: 85px; */
	padding-right: 85px;
	padding-bottom: 15px;
	border: solid;
	border-top-width: 1px;
	border-left-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 1px;
	border-color: gray;
	
}

.section-03 {
	padding-top: 25px;
 	padding-left: 11%; 
	padding-right: 85px;
	padding-bottom: 15px;
	border: solid;
	border-top-width: 0px;
	border-left-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 1px;
	border-color: gray;
}

.section-04 {
	padding-top: 25px;
 	padding-left: 85px; 
	padding-right: 85px;
	padding-bottom: 15px;
	border: solid;
	border-top-width: 0px;
	border-left-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 1px;
	border-color: gray;
}


/* ----- | Global Settings | ----- */


/*GLOBAL alignments */

.text-center {
	text-align: center;
}

.center-block {
	display: block;
	margin-right: auto;
	margin-left: auto;
}

.pull-right {
	float: right !important;
}

.pull-left {
	float: left !important;
}


/* GLOBAL pure btn custom */

.pure-button {
	border: solid;
	border-color: gray;
	border-width: 1px;
	border-radius:3px;
}

.button-xsmall {
	font-size: 70%;
}

.button-small {
	font-size: 85%;
}

.button-large {
	font-size: 110%;
}

.button-xlarge {
	font-size: 125%;
	font-weight:bold;
}

.new-row-btn,.new-row-btn:hover {
	width:900px;
	border:none;
	background:none;
	font-weight:bold;
}



input {
	color: #4F4F4F;
	text-align: left;
}


/* ----- | Global Settings End | ----- */

.cur_span{
  position:absolute;
}

/* .currency {
  padding-left:12px;
}

.currency-symbol {
  position:absolute;
  padding: 1px 5px;
} */

.balance-success {
	background:#53D489 !important;
}
.balance-warning {
	background:#D4C953 !important;
}
.balance-danger {
	background:#D45353 !important;
}

.alert-warning {
	color:#D45353;
	font-weight: bolder;
}
.alert-success {
	color:green;
	font-weight: bolder;
}



</style>

<script>

/*----------------------------------------------------------------------------//
entree id value is on ID:entree-id
date value is on ID:entree-date

------------------------------------------------------------------------------*/
//this 1st section is not mine///
(function(b) {
	var c = {
		allowFloat: false,
		allowNegative: false
	};
	b.fn.numericInput = function(e) {
		var f = b.extend({}, c, e);
		var d = f.allowFloat;
		var g = f.allowNegative;
		this.keypress(function(j) {
			var i = j.which;
			var h = b(this).val();
			if (i > 0 && (i < 48 || i > 57)) {
				if (d == true && i == 46) {
					if (g == true && a(this) == 0 && h.charAt(0) == "-") {
						return false
					}
					if (h.match(/[.]/)) {
						return false
					}
				} else {
					if (g == true && i == 45) {
						if (h.charAt(0) == "-") {
							return false
						}
						if (a(this) != 0) {
							return false
						}
					} else {
						if (i == 8) {
							return true
						} else {
							return false
						}
					}
				}
			} else {
				if (i > 0 && (i >= 48 && i <= 57)) {
					if (g == true && h.charAt(0) == "-" && a(this) == 0) {
						return false
					}
				}
			}
		});
		return this
	};

	function a(d) {
		if (d.selectionStart) {
			return d.selectionStart
		} else {
			if (document.selection) {
				d.focus();
				var f = document.selection.createRange();
				if (f == null) {
					return 0
				}
				var e = d.createTextRange(),
				g = e.duplicate();
				e.moveToBookmark(f.getBookmark());
				g.setEndPoint("EndToStart", e);
				return g.text.length
			}
		}
		return 0
	}
}(jQuery));
//^^ not mine//


$(document).ready(function() {

	inputhighlight();
	
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
												// update totals on "change" //
	$("input").change(function(){
		btn_t_update();
	})
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
							// changes inputs to display decimals at all times//
	$(document).on('blur',"input[type='number']",function(){
		if ($(this).val() != "" ) {
			$(this).val(parseFloat($(this).val()).toFixed(2));
		}
	});
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
											//requests account dropdown options//
	$.post("/oop/includes/select_chart_of_accounts.php",
	{select_account : "true"},function(response){
		$(".select_account, #select_account").html(response);
	});
	
});
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
											/// highlight row on input focus ///
function inputhighlight() {
	$('.row-input-group').focus(function() {
		$(this).closest('tr').addClass('active');
	});
	$('.row-input-group').blur(function() {
		$(this).closest('tr').removeClass('active');
	});
};
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
												///creates a new row in table///
function newRow() {
	var tr_s = "<tr name='entree-row' class='entree-row '>";
	var tr_btn_s = "<tr class='button-row'>";
	var tr_e = "</tr>";
	var account_in_s = '<td><select required class="row-input-group" name="account_in" style="width:250px;">';
	var select_account = $("#select_account").html();
	var row_insert = $("#row_insert").html();
	var select_account_e = '</select></td>';
	var credit_in = '<td><span class="cur_span"><i class="fa fa-usd" aria-hidden="true"></i></span><input style="width:60px;  margin-left:20px;" onkeyUp="update_in(\'credit_in\');" name="credit_in" class="row-input-group"  type="number" data-type=\'decimal\'  placeholder=\'0.00\' /></td>';
	var debit_in = '<td><span class="cur_span"><i class="fa fa-usd" aria-hidden="true"></i></span><input style="width:60px;  margin-left:20px;"  onkeyUp="update_in(\'debit_in\');" name="debit_in" class="row-input-group"  type="number" data-type="decimal"  placeholder=\'0.00\' /></td>';
	var memo_in = '<td><input style="width:500px;"  name="memo_in" class="row-input-group" type="text"/></td>';
	var add_button = '<td style="text-align:center;" colspan="5"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
	var remove_button = '<td><button   tabindex = "-1" class="pure-button remove-btn  "><i style="color:white;" class="fa fa-times" aria-hidden="true"></i></button></td>';
	///removes row with add button/// 
	$(".button-row").remove();
	///adds row with inputs and last row with add button///
	$(".row-body").append(tr_s+account_in_s+select_account+select_account_e+debit_in+credit_in+memo_in+remove_button+tr_e+tr_btn_s+add_button+tr_e);
	///enables focus highlight on new rows///
	inputhighlight();
};
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
												///Remove a row with X button ///
$('#journal-entrees').on('click','button',function(e) {
	$(this).closest('tr').remove();
	btn_t_update();
});
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
																///close window//
function close_window(url) {
	var newWindow = window.open('','_self',''); //open the current window
	window.close(url);
}
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
											//update totals when removing a row//
function btn_t_update() {
	var d_totals="debit_in";
	var c_totals="credit_in";
	update_in(d_totals);
	update_in(c_totals);
}

// $(".remove-btn").click(function( event ) {
//   event.preventDefault();
// });

//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
										//update value totals on input changes//
function update_in(name) {
	var taskArray=new Array();
	$("input[name*='"+name+"']").each(function() {
		if ($(this).val()) {
			taskArray.push($(this).val());
		}
	});
	var result = taskArray.map(function(x) {
		return parseFloat(x,".");
	});
	var sum=result.reduce(function(a,b) {
		return a+b;
	},0);
	var sum=sum.toFixed(2);
	$("#total_"+name).text(sum);
	$("#total_"+name).formatCurrency();
	balanceTotals();
	$("input[name='testIndex[]']").val(sum);
}
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
												/// Format Curency function ///
(function($) {
	$.formatCurrency={};
	$.formatCurrency.regions=[];
	$.formatCurrency.regions[""]= {
		symbol: "$",
		positiveFormat: "%s%n",
		negativeFormat: "(%s%n)",
		decimalSymbol: ".",
		digitGroupSymbol: ",",
		groupDigits: true
	};
	$.fn.formatCurrency = function(destination, settings) {
		if (arguments.length == 1 && typeof destination !== "string") {
			settings = destination;
			destination = false
		}
		var defaults = {
			name: "formatCurrency",
			colorize: false,
			region: "",
			global: true,
			roundToDecimalPlace: 2,
			eventOnDecimalsEntered: false
		};
		defaults = $.extend(defaults, $.formatCurrency.regions[""]);
		settings = $.extend(defaults, settings);
		if (settings.region.length > 0) {
			settings = $.extend(settings, getRegionOrCulture(settings.region))
		}
		settings.regex = generateRegex(settings);
		return this.each(function() {
			$this = $(this);
			var num = "0";
			num = $this[$this.is("input, select, textarea") ? "val" : "html"]();
			if (num.search("\\(") >= 0) {
				num = "-" + num
			}
			if (num === "" || (num === "-" && settings.roundToDecimalPlace === -1)) {
				return
			}
			if (isNaN(num)) {
				num = num.replace(settings.regex, "");
				if (num === "" || (num === "-" && settings.roundToDecimalPlace === -1)) {
					return
				}
				if (settings.decimalSymbol != ".") {
					num = num.replace(settings.decimalSymbol, ".")
				}
				if (isNaN(num)) {
					num = "0"
				}
			}
			var numParts = String(num).split(".");
			var isPositive = (num == Math.abs(num));
			var hasDecimals = (numParts.length > 1);
			var decimals = (hasDecimals ? numParts[1].toString() : "0");
			var originalDecimals = decimals;
			num = Math.abs(numParts[0]);
			num = isNaN(num) ? 0 : num;
			if (settings.roundToDecimalPlace >= 0) {
				decimals = parseFloat("1." + decimals);
				decimals = decimals.toFixed(settings.roundToDecimalPlace);
				if (decimals.substring(0, 1) == "2") {
					num = Number(num) + 1
				}
				decimals = decimals.substring(2)
			}
			num = String(num);
			if (settings.groupDigits) {
				for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) {
					num = num.substring(0, num.length - (4 * i + 3)) + settings.digitGroupSymbol + num.substring(num.length - (4 * i + 3))
				}
			}
			if ((hasDecimals && settings.roundToDecimalPlace == -1) || settings.roundToDecimalPlace > 0) {
				num += settings.decimalSymbol + decimals
			}
			var format = isPositive ? settings.positiveFormat : settings.negativeFormat;
			var money = format.replace(/%s/g, settings.symbol);
			money = money.replace(/%n/g, num);
			var $destination = $([]);
			if (!destination) {
				$destination = $this
			} else {
				/* global $this */
				$destination = $(destination)
			}
			$destination[$destination.is("input, select, textarea") ? "val" : "html"](money);
			if (hasDecimals && settings.eventOnDecimalsEntered && originalDecimals.length > settings.roundToDecimalPlace) {
				$destination.trigger("decimalsEntered", originalDecimals)
			}
			if (settings.colorize) {
				$destination.css("color", isPositive ? "black" : "red")
			}
		})
	};
	
	$.fn.toNumber = function(settings) {
		var defaults = $.extend({
			name: "toNumber",
			region: "",
			global: true
		}, $.formatCurrency.regions[""]);
		settings = jQuery.extend(defaults, settings);
		if (settings.region.length > 0) {
			settings = $.extend(settings, getRegionOrCulture(settings.region))
		}
		settings.regex = generateRegex(settings);
		return this.each(function() {
			var method = $(this).is("input, select, textarea") ? "val" : "html";
			$(this)[method]($(this)[method]().replace("(", "(-").replace(settings.regex, ""))
		})
	};
	
	$.fn.asNumber = function(settings) {
		var defaults = $.extend({
			name: "asNumber",
			region: "",
			parse: true,
			parseType: "Float",
			global: true
		}, $.formatCurrency.regions[""]);
		settings = jQuery.extend(defaults, settings);
		if (settings.region.length > 0) {
			settings = $.extend(settings, getRegionOrCulture(settings.region))
		}
		settings.regex = generateRegex(settings);
		settings.parseType = validateParseType(settings.parseType);
		var method = $(this).is("input, select, textarea") ? "val" : "html";
		var num = $(this)[method]();
		num = num ? num : "";
		num = num.replace("(", "(-");
		num = num.replace(settings.regex, "");
		if (!settings.parse) {
			return num
		}
		if (num.length == 0) {
			num = "0"
		}
		if (settings.decimalSymbol != ".") {
			num = num.replace(settings.decimalSymbol, ".")
		}
		return window["parse" + settings.parseType](num)
	};
	
	function getRegionOrCulture(region) {
		var regionInfo = $.formatCurrency.regions[region];
		if (regionInfo) {
			return regionInfo
		} else {
			if (/(\w+)-(\w+)/g.test(region)) {
				var culture = region.replace(/(\w+)-(\w+)/g, "$1");
				return $.formatCurrency.regions[culture]
			}
		}
		return null
	}
	
	function validateParseType(parseType) {
		switch (parseType.toLowerCase()) {
			case "int":
				return "Int";
			case "float":
				return "Float";
			default:
				throw "invalid parseType"
		}
	}
	
	function generateRegex(settings) {
		if (settings.symbol === "") {
			return new RegExp("[^\\d" + settings.decimalSymbol + "-]", "g")
		} else {
			var symbol = settings.symbol.replace("$", "\\$").replace(".", "\\.");
			return new RegExp(symbol + "|[^\\d" + settings.decimalSymbol + "-]", "g")
		}
	}
	/* global jQuery */
})(jQuery);
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
													/// datapicker function ///
// $(function() {
// 	$(".date").datepicker(
// 		{dateFormat:"yy-mm-dd"}
// 		,"option"
// 		,"showAnim"
// 		,"fadeIn"
// 	);
// });	
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
/* global $*/											/// submit function ///
function saveEntree(){
	var rows=$(".entree-row").length++;
	var entreeId=$("#entree-id").val();
	var date=$("#entree-date").val();
	var	rowEntree=new Array();
	var entree_info={"entreeId":entreeId,"date":date};
	for(var row_id=0;row_id<rows;row_id++){
		rowEntree[row_id]=row_id; 
	}
	for(var i=0;i<rowEntree.length;i++){
		var row=i;
		var acct=$("tr.entree-row:eq("+i+") select[name='account_in']").val();	
		var debit=$("tr.entree-row:eq("+i+") input[name='debit_in']").val();
		var credit=$("tr.entree-row:eq("+i+") input[name='credit_in']").val();
		var memo=$("tr.entree-row:eq("+i+") input[name='memo_in']").val();	
//--/--/--/--/ if values are null.../--/--/--//
		if(debit=="") {
			debit=0.00;
		}
		if(credit=="") {
			credit=0.00;
		}
		if (memo=="") {
			memo="no memo";
		}
		rowEntree[i]= {"acct": acct,"Debit": debit,"credit":credit,"memo":memo };
	}
//--//places entryid and date at first array index //
	rowEntree.unshift(entree_info);
//--// post to server side //
	$.ajax('ajax/journal_entries.php', {
	    type: 'post',
	    data: JSON.stringify(rowEntree),
	    dataType: 'json',
	    contentType: 'application/json',
	    success: function(data) {$("#alert-msg").html(rows+" journal entries were submitted. <i class=\"fa fa-check-circle alert-success \" aria-hidden=\"true\"></i>").removeClass().addClass("alert-success text-center"); }
	});
}
//--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--/
											/// highlight function for totals ///
function balanceTotals() {
	var total_debit = "#total_debit_in";
	var total_credit = "#total_credit_in";
	var credit = $(total_credit).text();
	var debit = $(total_debit).text();
	var msg_01 = "Oops! Something is not right, credit amount is less than debit amount!  "+ "<i class=\"fa fa-exclamation-triangle alert-warning\" aria-hidden=\"true\"></i> ";
	var msg_02 = "Oops! Something is not right, debit amount is greater than debit amount!  "+ "<i class=\"fa fa-exclamation-triangle alert-warning\" aria-hidden=\"true\"></i>";
	var msg_03 = "You're good!  "+ "<i class=\"fa fa-check-circle alert-success \" aria-hidden=\"true\"></i>";
	var alert_container = "#alert-msg";
	var cl_b_danger = "balance-danger text-center";
	var cl_b_warning = "balance-warning text-center";
	var cl_a_warning = "alert-warning text-center";
	var cl_b_success = "balance-success text-center";
	var cl_a_success = "alert-success text-center";
	if (credit < debit){
		$(total_credit).removeClass().addClass(cl_b_danger);
		$(total_debit).removeClass().addClass(cl_b_warning);
		// $(alert_container).html(msg_01).removeClass().addClass(cl_a_warning);
	} else if (credit > debit){
		$(total_credit).removeClass().addClass(cl_b_warning);
		$(total_debit).removeClass().addClass(cl_b_danger);
		// $(alert_container).html(msg_02).removeClass().addClass(cl_a_warning);
	}	else if (credit == debit){
		$(total_credit).removeClass().addClass(cl_b_success);
		$(total_debit).removeClass().addClass(cl_b_success);
		// $(alert_container).html(msg_03).removeClass().addClass(cl_a_success);
	}
}
</script>