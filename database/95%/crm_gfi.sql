/*
 Navicat Premium Dump SQL

 Source Server         : miste_ry
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : crm_gfi

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 20/11/2024 19:58:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for administrator_clinicrecord_table
-- ----------------------------
DROP TABLE IF EXISTS `administrator_clinicrecord_table`;
CREATE TABLE `administrator_clinicrecord_table`  (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `administrator_id` int NULL DEFAULT NULL,
  `illness` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `symptoms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_diagnosed` date NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`record_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of administrator_clinicrecord_table
-- ----------------------------
INSERT INTO `administrator_clinicrecord_table` VALUES (1, 1231, 'asd', 'asd', '2024-08-31', 'asdasd', '1');
INSERT INTO `administrator_clinicrecord_table` VALUES (12, 1231, 'asd', 'asd', '2024-09-04', 'asd', '2');

-- ----------------------------
-- Table structure for medical_history_table
-- ----------------------------
DROP TABLE IF EXISTS `medical_history_table`;
CREATE TABLE `medical_history_table`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `existing_condition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `documents` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_submitted` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of medical_history_table
-- ----------------------------
INSERT INTO `medical_history_table` VALUES (1, '4', 'covid', 'FINAL-ENHANCE-INVENTORY-FINALS02. (1).docx', 'Student', '2024-10-04');
INSERT INTO `medical_history_table` VALUES (2, '11111', 'covid', 'FINAL-ENHANCE-INVENTORY-FINALS02. (1).docx', 'Student', '2024-10-04');
INSERT INTO `medical_history_table` VALUES (3, '1231', 'covid', 'FINAL-ENHANCE-INVENTORY-FINALS02. (1).pdf', 'Student', '2024-10-04');

-- ----------------------------
-- Table structure for medicines
-- ----------------------------
DROP TABLE IF EXISTS `medicines`;
CREATE TABLE `medicines`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `medicine_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `medicine_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expiry_date` date NOT NULL,
  `manufacturer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosage` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `frequency` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `storage_temperature` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `storage_instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `stock` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `reorder_point` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of medicines
-- ----------------------------
INSERT INTO `medicines` VALUES (1, 'asd', 'asd', 'Capsule', '2024-08-13', 'asd', '123', '123', '123', 'asd', '123', '2024-08-12 11:07:57', 11, 'Received', 10);
INSERT INTO `medicines` VALUES (2, 'Bioflu', 'Bear Brand', 'Tablet', '2024-08-29', 'shinko', '123', '123', '21', '35%', 'normal', '2024-08-29 14:01:12', 500, 'On Process', 200);
INSERT INTO `medicines` VALUES (3, 'Alaxan', 'Bionalab', 'Tablet', '2024-11-20', 'Genx', '12', '3', '12', '12', 'asd', '2024-11-20 13:23:51', 9, NULL, 10);
INSERT INTO `medicines` VALUES (4, 'Boscupan', 'Unilab', 'Tablet', '2024-11-21', 'mistery', '200', '3', '12', '12', 'make sure dont stored in dry place', '2024-11-20 19:46:03', 219, NULL, 20);

-- ----------------------------
-- Table structure for message_conversation
-- ----------------------------
DROP TABLE IF EXISTS `message_conversation`;
CREATE TABLE `message_conversation`  (
  `message_req_id` int NOT NULL AUTO_INCREMENT,
  `message_title_id` int NULL DEFAULT NULL,
  `reply` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_reply` date NULL DEFAULT current_timestamp,
  PRIMARY KEY (`message_req_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of message_conversation
-- ----------------------------
INSERT INTO `message_conversation` VALUES (1, 2, 'asd', '1', '2024-10-28');
INSERT INTO `message_conversation` VALUES (2, 1, 'asd', '1', '2024-10-28');
INSERT INTO `message_conversation` VALUES (3, 2, 'asd', '1', '2024-10-28');

-- ----------------------------
-- Table structure for message_request_tbl
-- ----------------------------
DROP TABLE IF EXISTS `message_request_tbl`;
CREATE TABLE `message_request_tbl`  (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NULL DEFAULT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_send` date NULL DEFAULT current_timestamp,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`message_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of message_request_tbl
-- ----------------------------
INSERT INTO `message_request_tbl` VALUES (1, 1231, 'asd', NULL, 'Request');
INSERT INTO `message_request_tbl` VALUES (2, 1231, 'asdasdasd', '2024-10-27', 'Read');

-- ----------------------------
-- Table structure for prescribed_medicine_table
-- ----------------------------
DROP TABLE IF EXISTS `prescribed_medicine_table`;
CREATE TABLE `prescribed_medicine_table`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `record_id` int NULL DEFAULT NULL,
  `medicine_id` int NULL DEFAULT NULL,
  `quantity` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of prescribed_medicine_table
-- ----------------------------
INSERT INTO `prescribed_medicine_table` VALUES (1, 1, 1, '100', '1');
INSERT INTO `prescribed_medicine_table` VALUES (2, 1, 2, '500', '1');
INSERT INTO `prescribed_medicine_table` VALUES (3, 1, 1, '1', '1');
INSERT INTO `prescribed_medicine_table` VALUES (4, 12, 2, '3', '2');
INSERT INTO `prescribed_medicine_table` VALUES (5, 14, 2, '222', '2');
INSERT INTO `prescribed_medicine_table` VALUES (6, 14, 1, '2', '2');
INSERT INTO `prescribed_medicine_table` VALUES (7, 15, 2, '95', '1');
INSERT INTO `prescribed_medicine_table` VALUES (8, 16, 2, '176', '1');

-- ----------------------------
-- Table structure for registrations
-- ----------------------------
DROP TABLE IF EXISTS `registrations`;
CREATE TABLE `registrations`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `student_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_grade` int NOT NULL,
  `organization_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `organization_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `personal_statement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of registrations
-- ----------------------------

-- ----------------------------
-- Table structure for reorder_medicine
-- ----------------------------
DROP TABLE IF EXISTS `reorder_medicine`;
CREATE TABLE `reorder_medicine`  (
  `reorder_id` int NOT NULL AUTO_INCREMENT,
  `medicine_id` int NOT NULL,
  `current_stock` int NOT NULL,
  `reorder_quantity` int NOT NULL,
  `reorder_status` enum('Pending','Ordered','Received') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Pending',
  `reorder_date` date NOT NULL,
  `reorder_process_date` date NOT NULL,
  `additional_notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_request` int NULL DEFAULT NULL,
  PRIMARY KEY (`reorder_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of reorder_medicine
-- ----------------------------
INSERT INTO `reorder_medicine` VALUES (2, 1, 1, 500, 'Received', '2024-08-29', '2024-08-30', '123', NULL);
INSERT INTO `reorder_medicine` VALUES (3, 2, 0, 20, 'Pending', '2024-11-20', '0000-00-00', NULL, NULL);
INSERT INTO `reorder_medicine` VALUES (4, 2, 0, 400, 'Pending', '2024-11-20', '0000-00-00', NULL, NULL);
INSERT INTO `reorder_medicine` VALUES (5, 2, 4, 2, 'Pending', '2024-11-20', '0000-00-00', NULL, NULL);
INSERT INTO `reorder_medicine` VALUES (6, 2, 4, 500, 'Pending', '2024-11-20', '0000-00-00', NULL, NULL);
INSERT INTO `reorder_medicine` VALUES (7, 2, 4, 600, 'Pending', '2024-11-20', '0000-00-00', NULL, NULL);
INSERT INTO `reorder_medicine` VALUES (8, 2, 4, 6, 'Pending', '2024-11-20', '0000-00-00', NULL, NULL);
INSERT INTO `reorder_medicine` VALUES (9, 2, 4, 100, 'Pending', '2024-11-20', '0000-00-00', NULL, NULL);
INSERT INTO `reorder_medicine` VALUES (10, 1, 0, 11, 'Pending', '2024-11-20', '0000-00-00', NULL, NULL);
INSERT INTO `reorder_medicine` VALUES (11, 4, 19, 200, 'Pending', '2024-11-20', '0000-00-00', NULL, 219);

-- ----------------------------
-- Table structure for staff_clinic_record_table
-- ----------------------------
DROP TABLE IF EXISTS `staff_clinic_record_table`;
CREATE TABLE `staff_clinic_record_table`  (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `staff_id` int NULL DEFAULT NULL,
  `illness` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `symptoms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_diagnosed` date NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`record_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of staff_clinic_record_table
-- ----------------------------
INSERT INTO `staff_clinic_record_table` VALUES (1, 1231, 'asd', 'asd', '2024-08-31', 'asdasd', NULL);
INSERT INTO `staff_clinic_record_table` VALUES (12, 1231, 'asd', 'asd', '2024-09-04', 'asd', NULL);
INSERT INTO `staff_clinic_record_table` VALUES (13, 1231, 'asd', 'asd', '2024-09-04', 'asd', NULL);
INSERT INTO `staff_clinic_record_table` VALUES (14, NULL, 'asd', 'asd', '2024-11-15', 'asd', NULL);

-- ----------------------------
-- Table structure for staff_table
-- ----------------------------
DROP TABLE IF EXISTS `staff_table`;
CREATE TABLE `staff_table`  (
  `staff_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `barangay` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `municipality` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_hired` date NOT NULL,
  `id_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`staff_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of staff_table
-- ----------------------------
INSERT INTO `staff_table` VALUES (1, 'admin', 'admin', 'asd', 'asd', '2024-08-29', 'Male', '', '', '', '', '', '', 'Administrator', '', '0000-00-00', NULL);
INSERT INTO `staff_table` VALUES (2, 'staff', '6OBVd%6xwS#L', 'staff', 'staff', '2024-11-15', 'Male', 'staff@gmail.com', '11111111111', 'asdasd', 'asdasd', 'ad', 'asd', 'Staff', 'Special Education', '2024-11-15', '1231');

-- ----------------------------
-- Table structure for student_clinic_record_table
-- ----------------------------
DROP TABLE IF EXISTS `student_clinic_record_table`;
CREATE TABLE `student_clinic_record_table`  (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NULL DEFAULT NULL,
  `illness` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `symptoms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_diagnosed` date NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`record_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of student_clinic_record_table
-- ----------------------------
INSERT INTO `student_clinic_record_table` VALUES (1, 1231, 'asd', 'asd', '2024-08-31', 'asdasd', NULL);
INSERT INTO `student_clinic_record_table` VALUES (12, 1231, 'asd', 'asd', '2024-09-04', 'asd', NULL);
INSERT INTO `student_clinic_record_table` VALUES (13, 1231, 'asd', 'asd', '2024-09-04', 'asd', NULL);
INSERT INTO `student_clinic_record_table` VALUES (15, 1231, 'Hubag Ngipon', 'pain', '2024-11-16', 'asd', NULL);
INSERT INTO `student_clinic_record_table` VALUES (16, 1231, 'Hubag Ngipon', 'pain', '2024-11-16', 'asd', NULL);

-- ----------------------------
-- Table structure for student_illness
-- ----------------------------
DROP TABLE IF EXISTS `student_illness`;
CREATE TABLE `student_illness`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `documents` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `chief_complain` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `illness` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `allergic_reaction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `medication` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dose` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `times_per_day` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student_illness
-- ----------------------------
INSERT INTO `student_illness` VALUES (1, '1231', 'CHAPTER 1-5 (2).docx', 'asd', 'asd', 'asd', 'sad', 'asd', 0, '2024-10-24', '2024-10-30', '2024-10-29 07:55:06');

-- ----------------------------
-- Table structure for students_table
-- ----------------------------
DROP TABLE IF EXISTS `students_table`;
CREATE TABLE `students_table`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `barangay` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `municipality` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `section` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `registration_date` date NOT NULL DEFAULT current_timestamp,
  `archive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of students_table
-- ----------------------------
INSERT INTO `students_table` VALUES (2, '1231', 'sample', 'sample', 'sample', 'sample', '2024-08-30', 'Male', 'sample@gmail.com', '09124804022', 'yusaville', 'sinawal', 'general santos city', 'south cotabato', '2024', 'zara', 'Information Technology', '2024-09-02', '0', NULL);
INSERT INTO `students_table` VALUES (3, 'asd', 'asd', '2Sgk3S5r_oR1', 'asd', 'asd', '2024-09-03', 'Female', 'asd@gmail.com', '1231231', 'asdasd', 'asd', 'asdas', 'dasd', '123', 'asd', 'Information Technology', '0000-00-00', '1', NULL);
INSERT INTO `students_table` VALUES (4, '12301', 'admin', '$2y$10$GaCbwTxM3ZmBYbpmODPQg.k.sNc6nYBtadcNLNo4UIaVTBWwqMbgi', 'asd', 'asd', '2024-10-04', 'Female', 'admin@gmail.com', '09635438188', 'asd', 'asd', 'asd', 'asd', '2024', 'zarah ', 'Information Technology', '0000-00-00', '1', NULL);
INSERT INTO `students_table` VALUES (5, '11111', 'admin', '$2y$10$G9Zx3knNaOG3hOZX5NPwqOd6IsgRQnmmVXH0LviKepyfH9K9nZRCq', 'asd', 'asd', '2024-10-03', 'Male', 'asdasd@gmail.com', '1231231', 'sd', 'asd', 'asd', 'asd', '2024', 'asd', 'Information Technology', '0000-00-00', '0', NULL);
INSERT INTO `students_table` VALUES (6, 'asdas', 'da', '$2y$10$lawKWzMrnCH1NeNpVC65Ye8vWiAbFbhi1j3W4tFyYcIfvvL8XeS1.', 'asd', 'asd', '2024-10-04', 'Male', 'asdasd@gmail.com', '1231231', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'Business Administration', '0000-00-00', '1', NULL);
INSERT INTO `students_table` VALUES (8, '15-15761', 'luffy', 'luffy', 'luffy', 'rayleigh', '2024-11-16', 'Male', '', '', '', '', '', '', '4', 'zarah', 'Information Technology', '2024-11-16', '0', NULL);
INSERT INTO `students_table` VALUES (9, '1234567', 'sample1', '$2y$10$qTilcmAJRfBHHz/SydYz1O4VSIzn7SetHziUqbAZRtKig6BIIDMcC', 'sample1', 'sample1', '2024-11-16', 'Male', '', '', '', '', '', '', '5', 'zarah', 'Information Technology', '2024-11-16', '0', NULL);
INSERT INTO `students_table` VALUES (10, 'asd', 'asd', '', '', '', '0000-00-00', '', 'asd@gmail.com', '', '', '', '', '', '', '', '', '2024-11-18', NULL, NULL);
INSERT INTO `students_table` VALUES (11, '11111', 'mik', '', '', '', '0000-00-00', '', 'mik@gmail.com', '', '', '', '', '', '', '', '', '2024-11-18', NULL, NULL);

-- ----------------------------
-- Table structure for students_table_copy
-- ----------------------------
DROP TABLE IF EXISTS `students_table_copy`;
CREATE TABLE `students_table_copy`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `barangay` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `municipality` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `section` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `registration_date` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of students_table_copy
-- ----------------------------
INSERT INTO `students_table_copy` VALUES (2, '1231', 'sample', 'sample', 'sample', 'sample', '2024-08-30', 'Male', 'sample@gmail.com', '09124804022', 'yusaville', 'sinawal', 'general santos city', 'south cotabato', '2024', 'zara', 'Information Technology', '2024-09-02');
INSERT INTO `students_table_copy` VALUES (3, 'asd', 'asd', '2Sgk3S5r_oR1', 'asd', 'asd', '2024-09-03', 'Female', 'asd@gmail.com', '1231231', 'asdasd', 'asd', 'asdas', 'dasd', '123', 'asd', 'Information Technology', '0000-00-00');
INSERT INTO `students_table_copy` VALUES (4, '12301', 'admin', '$2y$10$GaCbwTxM3ZmBYbpmODPQg.k.sNc6nYBtadcNLNo4UIaVTBWwqMbgi', 'asd', 'asd', '2024-10-04', 'Female', 'admin@gmail.com', '09635438188', 'asd', 'asd', 'asd', 'asd', '2024', 'zarah ', 'Information Technology', '0000-00-00');
INSERT INTO `students_table_copy` VALUES (5, '11111', 'admin', '$2y$10$G9Zx3knNaOG3hOZX5NPwqOd6IsgRQnmmVXH0LviKepyfH9K9nZRCq', 'asd', 'asd', '2024-10-03', 'Male', 'asdasd@gmail.com', '1231231', 'sd', 'asd', 'asd', 'asd', '2024', 'asd', 'Information Technology', '0000-00-00');
INSERT INTO `students_table_copy` VALUES (6, 'asdas', 'da', '$2y$10$lawKWzMrnCH1NeNpVC65Ye8vWiAbFbhi1j3W4tFyYcIfvvL8XeS1.', 'asd', 'asd', '2024-10-04', 'Male', 'asdasd@gmail.com', '1231231', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'Business Administration', '0000-00-00');

-- ----------------------------
-- Table structure for teachers_table
-- ----------------------------
DROP TABLE IF EXISTS `teachers_table`;
CREATE TABLE `teachers_table`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `barangay` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `municipality` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_hired` date NOT NULL,
  `teacher_id` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of teachers_table
-- ----------------------------
INSERT INTO `teachers_table` VALUES (2, 'teacher', 'teacher', '', '', '0000-00-00', 'Male', '', '', '', '', '', '', '', '', '0000-00-00', '1231');

SET FOREIGN_KEY_CHECKS = 1;
