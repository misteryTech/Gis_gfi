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

 Date: 24/10/2024 10:34:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of encoder
-- ----------------------------
INSERT INTO `encoder` VALUES (1, 'upload_encoder/Planet9_3840x2160.jpg', '123123', 'asd', 'asd', 'Male', '123', '123@gmail.com', 'second-year', 'bachelor-information-technology', 'encoder', '$2y$10$2cHsHqQqM5jzIu6vDKhLLeK9G5uzcFS2aAY384o.L1s9/d84Cax2K');

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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grade_access_requests_db
-- ----------------------------
INSERT INTO `grade_access_requests_db` VALUES (1, '12301', '1', 'Grades Ready to View', NULL, NULL, 'accepted', NULL);
INSERT INTO `grade_access_requests_db` VALUES (2, '12301', '1', 'Grades Ready to View', NULL, '2024-10-21', 'accepted', NULL);
INSERT INTO `grade_access_requests_db` VALUES (3, '12301', '1', 'Grades Ready to View', NULL, '2024-10-21', 'accepted', 5);
INSERT INTO `grade_access_requests_db` VALUES (4, '12301', '4', 'Grades Ready to View', NULL, '2024-10-22', 'accepted', 5);
INSERT INTO `grade_access_requests_db` VALUES (5, '12301', '4', 'Grades Ready to View', NULL, '2024-10-23', 'accepted', 5);

-- ----------------------------
-- Table structure for grades
-- ----------------------------
DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `grade` decimal(5, 2) NOT NULL,
  `assign_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_release` date NULL DEFAULT current_timestamp,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of grades
-- ----------------------------
INSERT INTO `grades` VALUES (1, 2, 4, 2.00, NULL, '2024-10-22', NULL);
INSERT INTO `grades` VALUES (2, 2, 6, 3.00, NULL, '2024-10-22', 'Request');
INSERT INTO `grades` VALUES (3, 5, 9, 2.00, NULL, '2024-10-22', NULL);
INSERT INTO `grades` VALUES (4, 5, 10, 3.00, NULL, '2024-10-22', 'Accepted');
INSERT INTO `grades` VALUES (5, 5, 8, 3.00, NULL, '2024-10-22', 'Accepted');

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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of print_attempts
-- ----------------------------
INSERT INTO `print_attempts` VALUES (1, 2, '2024-10-22', '1');
INSERT INTO `print_attempts` VALUES (2, 2, '2024-10-22', '1');
INSERT INTO `print_attempts` VALUES (3, 2, '2024-10-22', '1');
INSERT INTO `print_attempts` VALUES (4, 2, '2024-10-23', '1');
INSERT INTO `print_attempts` VALUES (5, 2, '2024-10-23', '1');

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
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `student_id`(`student_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` VALUES (2, 'uploads/302597659_483170430485654_5599727337940796982_n.jpg', '123123', 'Starbrightt', 'Gensans', 'Male', '09399213074', 'admin@gmail.com', '4th Year', 'bachelor-information-technology', 'student', 'student');
INSERT INTO `students` VALUES (3, 'uploads/Planet9_3840x2160.jpg', '1234567', 'Angel', 'Hubahib', 'Female', '3547654', 'admin@gmail.com', 'fourth-year', 'bachelor-information-technology', NULL, NULL);
INSERT INTO `students` VALUES (5, 'uploads/Planet9_3840x2160.jpg', '12301', 'Mich', 'Hubahib', 'Female', '09124804022', 'reydhenebueza0023@gmail.com', '2', 'bachelor-information', 'student', '$2y$10$Kq4PSw8OOcEEA0o.QFp5WONyRKuv8lHtNOQhRNOrIkFp7oyrW2QRG');

-- ----------------------------
-- Table structure for subjects
-- ----------------------------
DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year` enum('first-year','second-year','third-year','fourth-year') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `semester` enum('first-semester','second-semester') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subjects
-- ----------------------------
INSERT INTO `subjects` VALUES (4, 'asd3', 'asd', 'first-year', 'first-semester', '2.2');
INSERT INTO `subjects` VALUES (5, 'mistery12', 'it', 'second-year', 'first-semester', '5');
INSERT INTO `subjects` VALUES (6, 'it2', 'mistery2', 'first-year', 'second-semester', '5');
INSERT INTO `subjects` VALUES (7, 'aczxc', 'zxczxc', 'first-year', 'first-semester', '11');
INSERT INTO `subjects` VALUES (8, 'ASDZXCZ', 'ASDXC', 'third-year', 'first-semester', '1');
INSERT INTO `subjects` VALUES (9, 'cc101', 'Introduction to computing', 'first-year', 'first-semester', '3');
INSERT INTO `subjects` VALUES (10, '123123', 'asd', 'fourth-year', 'first-semester', '5');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'reymarkescalante12@gmail.com', '$2y$10$nVBgUC3Xk9oosxg/fxINEubGvpdeaDSI7YH3ACbqsnhXIqwxPmWDS', '2024-09-17 15:13:49');
INSERT INTO `users` VALUES (2, 'admin@gmail.com', '$2y$10$.AtWW/P/v3coofT9Q5tZNeuAD8qHyhr7CZrXAmbgLukVQ/NJGmjYa', '2024-09-17 15:17:50');
INSERT INTO `users` VALUES (3, 'reydhenebueza0023@gmail.com', '$2y$10$FBD5RdsAtVmrq65IGBqTVOpCZmVGvEf9XlZrXzIT8WMV2n4g8cO82', '2024-09-19 23:09:12');
INSERT INTO `users` VALUES (4, 'scammas2018@gmail.com', '$2y$10$avSly7amBkRCylzKOlcxgezwfjhtjGNni0zXKgAagFLJMxMcHGM3C', '2024-09-19 23:12:03');

SET FOREIGN_KEY_CHECKS = 1;
