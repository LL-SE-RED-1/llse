<?php
class createdatabase extends CI_Model{
	
	function test(){
		$this->db->query("create table classroom(classroom_id int AUTO_INCREMENT,campus int,building varchar(15),room int,capacity int,type int,primary key(classroom_id))");
		$this->db->query("create table apply(class_id int AUTO_INCREMENT,course_id int,teacher_id int,date date,state int,primary key(class_id))");
		$this->db->query("create table man_apply(class_id int,text varchar(200),date date,primary key(class_id))");
		$this->db->query("create table classes(class_id int AUTO_INCREMENT,course_id int,course_name varchar(15),classroom_id int,teacher_id int,teacher_name varchar(15),weekday int,classnum char(13),year int,season int,type int,campus int,building varchar(15),room int,testtime int,primary key(class_id))");
		$this->db->query("create table teach_sche(teacher_id int,M int,T int,W int,TH int,F int,primary key(teacher_id))");
		$this->db->query("create table room_sche(classroom_id int,M int,T int,W int,TH int,F int,primary key(classroom_id))");
		$this->db->query("create table imsCourse(course_id int,name varchar(15),primary key(course_id));");
		$this->db->query("create table imsTeacher(teacher_id int,name varchar(15),primary key(teacher_id));");
	}
}

?>

