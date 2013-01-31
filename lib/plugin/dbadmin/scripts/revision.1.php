<?php

/*
 *		UP 0 => 1
 */

//upgrade script from 0 to 1 BEFORE SQL script
function dbadmin_up_script_1_pre(DbLib $db) {
	//do nothing
}

//upgrade script from 0 to 1 AFTER SQL script
function dbadmin_up_script_1_post(DbLib $db) {
	//do nothing
}

/*
 *		DOWN 1 => 0
 */

//downgrade script from 1 to 0 BEFORE SQL script
function dbadmin_up_down_1_pre(DbLib $db) {
	//do nothing
}

//downgrade script from 1 to 0 AFTER SQL script
function dbadmin_up_down_1_post(DbLib $db) {
	//do nothing
}
