-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 13, 2023 lúc 10:03 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `hbwebsite`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_cred`
--

CREATE TABLE `admin_cred` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(30) NOT NULL,
  `admin_pass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_cred`
--

INSERT INTO `admin_cred` (`id`, `admin_name`, `admin_pass`) VALUES
(1, 'admin', 'abcd1234'),
(2, 'hvtad', 'password');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_details_table`
--

CREATE TABLE `booking_details_table` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_details_table`
--

INSERT INTO `booking_details_table` (`id`, `booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`) VALUES
(1, 7, '512A1', 500000, 2500000, 'a5', 'Trần Duy Nam', '0343636602', 'Thai Binh'),
(2, 8, '011B3', 1500000, 6000000, NULL, 'Trần Duy Nam', '0343636602', 'Thai Binh'),
(3, 9, '512A1', 500000, 2500000, NULL, 'Hà Việt Thắng', '0343636602', 'Hai Phong'),
(4, 10, '011B3', 1500000, 4500000, NULL, 'Trần Xuân Phương', '0334362526', 'Hà Nội'),
(5, 11, '512A1', 500000, 3000000, NULL, 'Trần Xuân Phương', '0334362526', 'Hà Nội'),
(6, 12, '011B3', 1500000, 13500000, NULL, 'Hà Việt Thắng', '0343636602', 'Hai Phong'),
(7, 13, '512A1', 500000, 8000000, 'a345', 'Phạm Thanh Tùng', '0325748698', 'Hải Phòng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carousel_table`
--

CREATE TABLE `carousel_table` (
  `id` int(11) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carousel_table`
--

INSERT INTO `carousel_table` (`id`, `image`) VALUES
(5, 'IMG_40905.png'),
(6, 'IMG_55677.png'),
(7, 'IMG_62045.png'),
(8, 'IMG_93127.png'),
(9, 'IMG_99736.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_table`
--

CREATE TABLE `contact_table` (
  `id` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` bigint(30) NOT NULL,
  `pn2` bigint(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `insta` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_table`
--

INSERT INTO `contact_table` (`id`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, 'Hon Dau Resort, Khu 3, Do Son, Hai Phong', 'https://maps.app.goo.gl/XnXrp8JDiNeGBj826', 84739027431, 84343636602, 'info@hondauresort.com', 'https://www.facebook.com/hondauresort', 'https://www.facebook.com/hondauresort', 'https://www.facebook.com/hondauresort', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d29862.012701396343!2d106.804276!3d20.679683!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a6d5e15aed325:0x6ddb33e93b040a42!2zSMOSTiBE4bqkVSBSRVNPUlQ!5e0!3m2!1svi!2sus!4v1699633872886!5m2!1svi!2sus');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `facilities_table`
--

CREATE TABLE `facilities_table` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `decription` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `facilities_table`
--

INSERT INTO `facilities_table` (`id`, `name`, `icon`, `decription`) VALUES
(1, 'Hệ thống sưởi', 'IMG_27079.svg', ''),
(2, 'TV', 'IMG_41622.svg', ''),
(3, 'Wifi', 'IMG_43553.svg', ''),
(4, 'Massage', 'IMG_47816.svg', ''),
(5, 'Điều hoà', 'IMG_49949.svg', ''),
(6, 'Radio', 'IMG_96423.svg', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `features_table`
--

CREATE TABLE `features_table` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `features_table`
--

INSERT INTO `features_table` (`id`, `name`) VALUES
(4, 'Đa phòng'),
(5, 'Phòng tắm'),
(6, 'Ban công'),
(7, 'Sofa'),
(8, 'Phòng bếp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `management_members_table`
--

CREATE TABLE `management_members_table` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `management_members_table`
--

INSERT INTO `management_members_table` (`id`, `name`, `picture`) VALUES
(1, 'Ha Viet Thang', 'IMG_14517.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `momo_table`
--

CREATE TABLE `momo_table` (
  `id` int(11) NOT NULL,
  `partner_code` varchar(50) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `refund` int(11) DEFAULT NULL,
  `arrival` varchar(100) DEFAULT NULL,
  `order_info` varchar(100) NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `trans_id` int(11) NOT NULL,
  `pay_type` varchar(50) NOT NULL,
  `code_cart` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `momo_table`
--

INSERT INTO `momo_table` (`id`, `partner_code`, `order_id`, `user_id`, `room_id`, `amount`, `check_in`, `check_out`, `refund`, `arrival`, `order_info`, `order_type`, `trans_id`, `pay_type`, `code_cart`, `datetime`) VALUES
(7, 'MOMOBKUN20180529', 1701702167, 3, 9, '2500000', '2023-12-04', '2023-12-09', NULL, '1', 'Thanh toán qua MoMo', 'momo_wallet', 2147483647, 'napas', '2456', '2023-12-04 22:03:25'),
(8, 'MOMOBKUN20180529', 1701706125, 3, 10, '6000000', '2023-12-04', '2023-12-08', 0, NULL, 'Thanh toán qua MoMo', 'momo_wallet', 2147483647, 'napas', '5135', '2023-12-04 23:09:25'),
(9, 'MOMOBKUN20180529', 1701788308, 1, 9, '2500000', '2023-12-16', '2023-12-21', 0, NULL, 'Thanh toán qua MoMo', 'momo_wallet', 2147483647, 'napas', '1512', '2023-12-05 21:59:03'),
(10, 'MOMOBKUN20180529', 1702092583, 8, 10, '4500000', '2023-12-25', '2023-12-28', NULL, NULL, 'Thanh toán qua MoMo', 'momo_wallet', 2147483647, 'napas', '7700', '2023-12-09 10:30:28'),
(11, 'MOMOBKUN20180529', 1702130373, 8, 9, '3000000', '2024-01-01', '2024-01-07', NULL, NULL, 'Thanh toán qua MoMo', 'momo_wallet', 2147483647, 'napas', '9930', '2023-12-09 21:00:25'),
(12, 'MOMOBKUN20180529', 1702455448, 1, 10, '13500000', '2023-12-13', '2023-12-22', NULL, NULL, 'Thanh toán qua MoMo', 'momo_wallet', 2147483647, 'napas', '7755', '2023-12-13 15:18:00'),
(13, 'MOMOBKUN20180529', 1702457871, 11, 9, '8000000', '2023-12-13', '2023-12-29', NULL, '1', 'Thanh toán qua MoMo', 'momo_wallet', 2147483647, 'napas', '160', '2023-12-13 15:58:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms_facilities_table`
--

CREATE TABLE `rooms_facilities_table` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms_facilities_table`
--

INSERT INTO `rooms_facilities_table` (`id`, `room_id`, `facilities_id`) VALUES
(14, 9, 1),
(15, 9, 2),
(16, 9, 3),
(17, 9, 5),
(36, 10, 1),
(37, 10, 2),
(38, 10, 3),
(39, 10, 4),
(40, 10, 5),
(41, 10, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms_features_table`
--

CREATE TABLE `rooms_features_table` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms_features_table`
--

INSERT INTO `rooms_features_table` (`id`, `room_id`, `features_id`) VALUES
(11, 9, 4),
(12, 9, 5),
(13, 9, 6),
(29, 10, 4),
(30, 10, 5),
(31, 10, 6),
(32, 10, 7),
(33, 10, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms_table`
--

CREATE TABLE `rooms_table` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `decription` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms_table`
--

INSERT INTO `rooms_table` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `decription`, `status`, `removed`) VALUES
(9, '512A1', 512, 500000, 3, 1, 2, 'Simple room', 1, 0),
(10, '011B3', 11, 1500000, 4, 2, 2, 'The VIP beachfront resort room offers a breathtaking view of the ocean. The room is exquisitely designed with luxurious furnishings and amenities. The large windows allow natural light to illuminate the space, creating a serene and tranquil atmosphere. The room features a spacious king-size bed, a private balcony where guests can enjoy the mesmerizing sunset, and a well-appointed en-suite bathroom with a Jacuzzi tub. This exclusive retreat provides the perfect escape for those seeking a truly in', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_images_table`
--

CREATE TABLE `room_images_table` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `room_images_table`
--

INSERT INTO `room_images_table` (`id`, `room_id`, `image`, `thumb`) VALUES
(3, 9, 'IMG_16997.jpg', 1),
(9, 10, 'IMG_70583.png', 1),
(10, 9, 'IMG_42663.png', 0),
(11, 10, 'IMG_78809.png', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings_table`
--

CREATE TABLE `settings_table` (
  `id` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(500) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `settings_table`
--

INSERT INTO `settings_table` (`id`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'Khách sạn SVG', 'Khách sạn SVG - Khu nghỉ dưỡng tuyệt vời trên bãi biển!\n\nHãy tưởng tượng một kỳ nghỉ tuyệt vời tại khách sạn SVG, nằm trên bờ biển xinh đẹp. Với vị trí đắc địa, chúng tôi mang đến cho bạn những trải nghiệm khó quên, kết hợp tiện nghi hiện đại và không gian thiên nhiên thơ mộng.\n\nKhách sạn SVG với 200 phòng sang trọng, tiện nghi đa dạng sẽ đáp ứng mọi nhu cầu của quý khách. Đắm mình trong những căn phòng tiện nghi và rộng rãi, được thiết kế đẹp mắt với nội thất tinh xảo.\n\nVới bãi biển riêng chỉ c', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_account_table`
--

CREATE TABLE `user_account_table` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phonenum` varchar(30) NOT NULL,
  `pincode` int(11) NOT NULL,
  `birthdate` date NOT NULL,
  `picture` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `password` varchar(200) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `t_expire` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_account_table`
--

INSERT INTO `user_account_table` (`id`, `user_name`, `name`, `email`, `address`, `phonenum`, `pincode`, `birthdate`, `picture`, `password`, `is_verified`, `token`, `t_expire`, `status`, `datetime`) VALUES
(1, 'thangoghd', 'Hà Việt Thắng', 'thangteenx2@gmail.com', 'Hai Phong', '0343636602', 12345, '2023-11-08', 'IMG_41508.jpeg', '$2y$10$PMpeWqvGXW1R7gWR519oo.ijr.w7pN9Jyyb5v6F4mquYrXUzPvSQS', 1, NULL, NULL, 1, '2023-11-26 19:10:38'),
(3, 'starvegas', 'Trần Duy Nam', 'thang86082@st.vimaru.edu.vn', 'Thái Bình', '0343636602', 21635, '2023-12-04', 'IMG_65910.jpeg', '$2y$10$KXvtSHuWSw0IOTWiRXppE.BLwNPzLSqnuCYvC0.papqDRRXQOZ7cC', 1, '0', NULL, 1, '2023-12-04 19:38:15'),
(8, 'phuongvn', 'Trần Xuân Phương', 'phuongvn98@gmail.com', 'Hà Nội', '0334362526', 78556, '2023-12-08', 'default.jpg', '$2y$10$SP3xcwIkdtu2kMv63kackeJS45yEutgDIdoeVDsA3lfhULn5Jn.JS', 1, '0', NULL, 1, '2023-12-08 21:28:39'),
(10, 'hungng123', 'Nguyễn Huy Hùng', 'hung666@gmail.com', 'Hải Phòng', '0348046697', 14223, '2003-06-11', 'default.jpg', '$2y$10$ACmZrW9shtyXlgxSeRxMteW80pcYDs8gGgaF2L.x20l1Z23uRxTQ2', 1, '0', NULL, 1, '2023-12-13 13:39:26'),
(11, 'tungph123', 'Phạm Thanh Tùng', 'tungtt@gmail.com', 'Hải Phòng', '0325748698', 14775, '2023-12-13', 'default.jpg', '$2y$10$NxgeESXXNntTF9YhCDn4nuwqyt7kd8r5eQ2jWRUatIuXi8e7Y6d3y', 1, '0', NULL, 1, '2023-12-13 15:52:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_queries`
--

CREATE TABLE `user_queries` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_queries`
--

INSERT INTO `user_queries` (`id`, `name`, `email`, `subject`, `message`, `date`, `seen`) VALUES
(5, 'Ha Viet Thang', 'thangteenx2@gmail.com', 'Reservation issue', 'I am writing to express my disappointment and frustration regarding the booking process at your beach resort. Unfortunately, my recent experience with attempting to make a reservation has left me dissatisfied and compelled to bring the matter to your attention.\r\n\r\nI encountered several difficulties when attempting to book a room at your resort. The online booking system was slow and unresponsive, making it challenging to navigate and complete the necessary steps. Additionally, I was unable to make a booking due to overcapacity during my desired vacation dates. This forced me to rearrange my plans and find alternative accommodations, causing unnecessary stress and inconvenience.', '2023-11-16', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `booking_details_table`
--
ALTER TABLE `booking_details_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_details_table_ibfk_1` (`booking_id`);

--
-- Chỉ mục cho bảng `carousel_table`
--
ALTER TABLE `carousel_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_table`
--
ALTER TABLE `contact_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `facilities_table`
--
ALTER TABLE `facilities_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `features_table`
--
ALTER TABLE `features_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `management_members_table`
--
ALTER TABLE `management_members_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `momo_table`
--
ALTER TABLE `momo_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `rooms_facilities_table`
--
ALTER TABLE `rooms_facilities_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room id` (`room_id`),
  ADD KEY `facilities id` (`facilities_id`);

--
-- Chỉ mục cho bảng `rooms_features_table`
--
ALTER TABLE `rooms_features_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rm id` (`room_id`),
  ADD KEY `features id` (`features_id`);

--
-- Chỉ mục cho bảng `rooms_table`
--
ALTER TABLE `rooms_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `room_images_table`
--
ALTER TABLE `room_images_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room  id for image` (`room_id`);

--
-- Chỉ mục cho bảng `settings_table`
--
ALTER TABLE `settings_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_account_table`
--
ALTER TABLE `user_account_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `booking_details_table`
--
ALTER TABLE `booking_details_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `carousel_table`
--
ALTER TABLE `carousel_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `contact_table`
--
ALTER TABLE `contact_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `facilities_table`
--
ALTER TABLE `facilities_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `features_table`
--
ALTER TABLE `features_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `management_members_table`
--
ALTER TABLE `management_members_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `momo_table`
--
ALTER TABLE `momo_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `rooms_facilities_table`
--
ALTER TABLE `rooms_facilities_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `rooms_features_table`
--
ALTER TABLE `rooms_features_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `rooms_table`
--
ALTER TABLE `rooms_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `room_images_table`
--
ALTER TABLE `room_images_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `settings_table`
--
ALTER TABLE `settings_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `user_account_table`
--
ALTER TABLE `user_account_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking_details_table`
--
ALTER TABLE `booking_details_table`
  ADD CONSTRAINT `booking_details_table_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `momo_table` (`id`);

--
-- Các ràng buộc cho bảng `momo_table`
--
ALTER TABLE `momo_table`
  ADD CONSTRAINT `momo_table_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account_table` (`id`),
  ADD CONSTRAINT `momo_table_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms_table` (`id`);

--
-- Các ràng buộc cho bảng `rooms_facilities_table`
--
ALTER TABLE `rooms_facilities_table`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities_table` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms_table` (`id`) ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `rooms_features_table`
--
ALTER TABLE `rooms_features_table`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features_table` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `rm id` FOREIGN KEY (`room_id`) REFERENCES `rooms_table` (`id`) ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `room_images_table`
--
ALTER TABLE `room_images_table`
  ADD CONSTRAINT `room  id for image` FOREIGN KEY (`room_id`) REFERENCES `rooms_table` (`id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
