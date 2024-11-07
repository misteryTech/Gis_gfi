/*
 Navicat Premium Dump SQL

 Source Server         : miste_ry
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : gis_database

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 06/11/2024 19:51:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for course_table
-- ----------------------------
DROP TABLE IF EXISTS `course_table`;
CREATE TABLE `course_table`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_registered` date NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of course_table
-- ----------------------------
INSERT INTO `course_table` VALUES (1, 'BS in Accountancy', 'Accounting', '2024-11-05');
INSERT INTO `course_table` VALUES (2, 'BS in Management Accounting', 'Accounting', '2024-11-05');
INSERT INTO `course_table` VALUES (3, 'Bachelor of Secondary Education Major in English & Math', 'Education', '2024-11-05');
INSERT INTO `course_table` VALUES (4, 'BS in Information System', 'Bachelor Information System', '2024-11-05');

-- ----------------------------
-- Table structure for encoded_grades_table
-- ----------------------------
DROP TABLE IF EXISTS `encoded_grades_table`;
CREATE TABLE `encoded_grades_table`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NULL DEFAULT NULL,
  `encoder_id` int NULL DEFAULT NULL,
  `subject_id` int NULL DEFAULT NULL,
  `grade` decimal(5, 2) NULL DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of encoded_grades_table
-- ----------------------------
INSERT INTO `encoded_grades_table` VALUES (1, 5, 1, 19, NULL, NULL, 'tbe', NULL);
INSERT INTO `encoded_grades_table` VALUES (2, 5, 1, 18, NULL, NULL, 'failed', NULL);
INSERT INTO `encoded_grades_table` VALUES (3, 5, 1, 19, NULL, NULL, 'tbe', NULL);
INSERT INTO `encoded_grades_table` VALUES (4, 5, 1, 18, NULL, NULL, 'passed', NULL);
INSERT INTO `encoded_grades_table` VALUES (5, 5, 1, 19, 1.00, NULL, 'passed', NULL);
INSERT INTO `encoded_grades_table` VALUES (6, 5, 1, 18, 2.00, NULL, 'passed', NULL);
INSERT INTO `encoded_grades_table` VALUES (7, 5, 1, 19, 2.00, NULL, 'tbe', NULL);
INSERT INTO `encoded_grades_table` VALUES (8, 5, 1, 18, 1.00, NULL, 'failed', NULL);
INSERT INTO `encoded_grades_table` VALUES (9, 5, 1, 19, 2.00, NULL, 'passed', NULL);
INSERT INTO `encoded_grades_table` VALUES (10, 5, 1, 18, 3.00, NULL, 'failed', NULL);

-- ----------------------------
-- Table structure for encoder
-- ----------------------------
DROP TABLE IF EXISTS `encoder`;
CREATE TABLE `encoder`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `encoder_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `encoder_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `year_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `student_id`(`encoder_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of encoder
-- ----------------------------
INSERT INTO `encoder` VALUES (1, 'upload_encoder/Planet9_3840x2160.jpg', '123123', 'asd', 'asd', 'Male', '123', '123@gmail.com', 'second-year', 'bachelor-information-technology', 'encoder', '$2y$10$2cHsHqQqM5jzIu6vDKhLLeK9G5uzcFS2aAY384o.L1s9/d84Cax2K');
INSERT INTO `encoder` VALUES (2, 'upload_encoder/COPMP.jpg', 'eee', 'evaluator', 'evaluator', 'Male', '09635438188', 'evaluator@gmail.com', '', 'BS in Accountancy', 'evaluator', '$2y$10$mD7HPz7Hcpw211kxUagaDeQKiuJiP/rmVnFltSaTJvR1dtZV0z4aS');
INSERT INTO `encoder` VALUES (3, 'upload_encoder/Screenshot 2024-10-10 165347.png', '123', 'raydhan', 'raydhan', 'Male', '09635438188', 'raydhan@gmail.com', '', 'BS in Accountancy', 'raydhan', '$2y$10$YirYodxsiZoKfG7bjuQhee/ARJHi.aZnPi1PJXoePEHyVxr5xzPCC');
INSERT INTO `encoder` VALUES (4, 'upload_encoder/1729821250478.jpg', '76754', 'Rey', 'Dhen', 'Female', '09095553641', 'reydhen7@gmail.com', '', 'BS in Information System', 'rey123', '$2y$10$XxunLO.X5Vuec5xAutkMcOVXoFlvn/j4WIJDyHLUD/9huuAV.jKQu');
INSERT INTO `encoder` VALUES (5, 'upload_encoder/1729821287168.jpg', '2101012', 'Bryan', 'Baloro', 'Male', '0909090909', 'bryan123@gmail.com', '', 'BS in Accountancy', 'bryan123', '$2y$10$FiJV/H2r1WFzbM2bWKCGg.9cbJLevsgAMdhtndbaB/gLmhYNoXvPW');
INSERT INTO `encoder` VALUES (6, 'upload_encoder/Screenshot_2024-10-25-09-56-34-880_com.facebook.lite-edit.jpg', '1234567', 'Christian', 'Hermonio', 'Male', '0909090999', 'christian123@gmail.com', '', 'BS in Information System', 'christian122', '$2y$10$UCf6VAx0mNHK6sur6is7gu6jUpteXwD1FHRlB8CCw3Arxz3VFgMlu');

-- ----------------------------
-- Table structure for grade_access_requests_db
-- ----------------------------
DROP TABLE IF EXISTS `grade_access_requests_db`;
CREATE TABLE `grade_access_requests_db`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `staff_id` int NULL DEFAULT NULL,
  `date_request` date NULL DEFAULT current_timestamp,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `semester` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grade_access_requests_db
-- ----------------------------
INSERT INTO `grade_access_requests_db` VALUES (1, '12301', '1', 'Grades Ready to View', NULL, NULL, 'accepted', NULL, NULL);
INSERT INTO `grade_access_requests_db` VALUES (2, '12301', '1', 'Grades Ready to View', NULL, '2024-10-21', 'accepted', NULL, NULL);
INSERT INTO `grade_access_requests_db` VALUES (3, '12301', '1', 'Grades Ready to View', NULL, '2024-10-21', 'accepted', 5, NULL);
INSERT INTO `grade_access_requests_db` VALUES (4, '12301', '4', 'Grades Ready to View', NULL, '2024-10-22', 'accepted', 5, NULL);
INSERT INTO `grade_access_requests_db` VALUES (5, '12301', '4', 'Grades Ready to View', NULL, '2024-10-23', 'accepted', 5, NULL);
INSERT INTO `grade_access_requests_db` VALUES (6, '2101957', '4', 'Grades Ready to View', NULL, '2024-10-25', 'accepted', 6, NULL);
INSERT INTO `grade_access_requests_db` VALUES (7, '2101564', '4', 'Grades Ready to View', NULL, '2024-10-25', 'accepted', 12, NULL);
INSERT INTO `grade_access_requests_db` VALUES (8, '2101564', '1', 'Grades Ready to View', NULL, '2024-10-25', 'accepted', 12, NULL);
INSERT INTO `grade_access_requests_db` VALUES (9, '2101564', '1', 'Grades Ready to View', NULL, '2024-10-25', 'accepted', 12, NULL);
INSERT INTO `grade_access_requests_db` VALUES (10, '12301', '3', NULL, NULL, '2024-10-31', 'pending', 5, '2nd sem');

-- ----------------------------
-- Table structure for print_attempts
-- ----------------------------
DROP TABLE IF EXISTS `print_attempts`;
CREATE TABLE `print_attempts`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NULL DEFAULT NULL,
  `date_print` date NULL DEFAULT NULL,
  `attempts` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of print_attempts
-- ----------------------------
INSERT INTO `print_attempts` VALUES (1, 2, '2024-10-22', '1');
INSERT INTO `print_attempts` VALUES (2, 2, '2024-10-22', '1');
INSERT INTO `print_attempts` VALUES (3, 2, '2024-10-22', '1');
INSERT INTO `print_attempts` VALUES (4, 2, '2024-10-23', '1');
INSERT INTO `print_attempts` VALUES (5, 2, '2024-10-23', '1');
INSERT INTO `print_attempts` VALUES (6, 6, '2024-10-25', '1');
INSERT INTO `print_attempts` VALUES (7, 12, '2024-10-25', '1');

-- ----------------------------
-- Table structure for requirements
-- ----------------------------
DROP TABLE IF EXISTS `requirements`;
CREATE TABLE `requirements`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `steps` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of requirements
-- ----------------------------
INSERT INTO `requirements` VALUES (10, 'sd', 'asd', 'Step 1');
INSERT INTO `requirements` VALUES (11, 'school id', 'bring school id', 'Step 1');

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `student_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `year_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `student_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `student_id`(`student_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` VALUES (2, 'uploads/302597659_483170430485654_5599727337940796982_n.jpg', '123123', 'Starbrightt', 'Gensans', 'Male', '09399213074', 'admin@gmail.com', '4th Year', 'bachelor-information-technology', 'student', 'student', NULL);
INSERT INTO `students` VALUES (3, 'uploads/Planet9_3840x2160.jpg', '1234567', 'Angel', 'Hubahib', 'Female', '3547654', 'admin@gmail.com', 'fourth-year', 'bachelor-information-technology', NULL, NULL, NULL);
INSERT INTO `students` VALUES (5, 'uploads/Planet9_3840x2160.jpg', '12301', 'Mich', 'Hubahib', 'Female', '09124804022', 'reydhenebueza0023@gmail.com', '2', 'BS in Management Accounting', 'student', '$2y$10$Kq4PSw8OOcEEA0o.QFp5WONyRKuv8lHtNOQhRNOrIkFp7oyrW2QRG', 'Regular');
INSERT INTO `students` VALUES (6, 'uploads/1729821250478.jpg', '2101957', 'Reydhen', 'Ebueza', 'Male', '09098888951', 'reydhen7@gmail.com', '4', 'BS in Information System', 'reydhen', '$2y$10$dMFuZNUgegBWJRDrHrkuuuR7X6ztbRlAfW4pHBO56p8OYF4/5ANRy', NULL);
INSERT INTO `students` VALUES (11, 'uploads/Screenshot 2024-10-12 225211.png', 'sample', 'sample', 'sample', 'Male', '09107899222', 'sample@gmail.com', 'first-year', 'bs-entrepreneurship', 'sample', '$2y$10$UXvm4AjXoX4P16kMbEWh4OgKnd1pc14Y.MgxJHZiZ96WuJnUE6076', NULL);
INSERT INTO `students` VALUES (12, 'uploads/Screenshot_2024-10-25-09-56-34-880_com.facebook.lite-edit.jpg', '2101564', 'Christian', 'Hermonio', 'Male', '091234523', 'christian@gmail.com', 'fourth-year', 'BS in Accountancy', 'christian123', '$2y$10$.8e9swqtaOZeFP.Cs68M6O7u3DASgEYc8ZYttUU.eTy4MM1t1w9gS', NULL);
INSERT INTO `students` VALUES (13, 'uploads/c4e30b16-7349-43f0-9c25-3ebdd00e72de.jfif', '11111', 'Angel', 'Hubahib', 'Male', '11111111111', 'evaluator@gmail.com', 'third-year', 'asd', 'johnmichael.tan@deped.gov.ph', '$2y$10$WF9Ovg1YZuQHYXDzT9KEhukQ0aWRQb9mBGwkL6mLNqcJ6kIcptIUi', NULL);

-- ----------------------------
-- Table structure for subjects
-- ----------------------------
DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year` enum('first-year','second-year','third-year','fourth-year') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `semester` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `curriculum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `course` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `archive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subjects
-- ----------------------------
INSERT INTO `subjects` VALUES (14, 'CAP102', 'CAPSTONE 2', 'third-year', '3', '2', NULL, 'Bachelor of Secondary Education Major in English & Math', '1');
INSERT INTO `subjects` VALUES (15, 'sample', 'samples', 'fourth-year', '3', '1', NULL, 'Bachelor of Secondary Education Major in English & Math', '1');
INSERT INTO `subjects` VALUES (16, 'ACCT', 'Accounting', 'fourth-year', '3', '', NULL, 'BS in Management Accounting', '1');
INSERT INTO `subjects` VALUES (17, 'MATH', 'MAMAM', 'first-year', '2', '1', NULL, 'BS in Management Accounting', NULL);
INSERT INTO `subjects` VALUES (18, 'correct', 'correct', 'fourth-year', '12', '1', 'Old', 'BS in Management Accounting', NULL);
INSERT INTO `subjects` VALUES (19, 'cc101', 'Introduction to computing', 'first-year', '123', 'first-semester', 'New', 'BS in Management Accounting', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `course` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'reymarkescalante12@gmail.com', '$2y$10$nVBgUC3Xk9oosxg/fxINEubGvpdeaDSI7YH3ACbqsnhXIqwxPmWDS', '2024-09-17 15:13:49', NULL);
INSERT INTO `users` VALUES (2, 'admin@gmail.com', '$2y$10$.AtWW/P/v3coofT9Q5tZNeuAD8qHyhr7CZrXAmbgLukVQ/NJGmjYa', '2024-09-17 15:17:50', NULL);
INSERT INTO `users` VALUES (3, 'reydhenebueza0023@gmail.com', '$2y$10$FBD5RdsAtVmrq65IGBqTVOpCZmVGvEf9XlZrXzIT8WMV2n4g8cO82', '2024-09-19 23:09:12', NULL);
INSERT INTO `users` VALUES (4, 'scammas2018@gmail.com', '$2y$10$avSly7amBkRCylzKOlcxgezwfjhtjGNni0zXKgAagFLJMxMcHGM3C', '2024-09-19 23:12:03', NULL);

-- ----------------------------
-- Table structure for grades
-- ----------------------------
DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades`  () COMMENT = 'Table \'gis_database.grades\' doesn\'t exist in engine';