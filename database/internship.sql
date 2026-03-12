-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2026 at 10:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internship`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companis`
--

CREATE TABLE `companis` (
  `id` int(11) NOT NULL,
  `company_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companis`
--

INSERT INTO `companis` (`id`, `company_code`, `name`) VALUES
(1, 'turain', 'Turain'),
(2, 'TCS', 'Tata Consultancy Services'),
(3, 'ITC', 'ITC Limited'),
(4, 'BBL', 'Bandhan Bank'),
(5, 'CTS', 'Cognizant'),
(6, 'PWC', 'PwC India');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `created_at`, `updated_at`) VALUES
(1, 'Software Development', NULL, NULL),
(2, 'Web Development', NULL, NULL),
(3, 'Mobile App Development', NULL, NULL),
(4, 'UI/UX Design', NULL, NULL),
(5, 'Digital Marketing', NULL, NULL),
(6, 'Human Resource', NULL, NULL),
(7, 'Graphics Design', NULL, NULL),
(8, 'Project Management', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `name`, `code`) VALUES
(1, 'Team Leader', 'teamlead'),
(2, 'Employee', 'employee'),
(3, 'Intern', 'intern');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `state_id`, `name`) VALUES
(1, 28, 'Alipurduar'),
(2, 28, 'Bankura'),
(3, 28, 'Birbhum'),
(4, 28, 'Cooch Behar'),
(5, 28, 'Dakshin Dinajpur'),
(6, 28, 'Darjeeling'),
(7, 28, 'Hooghly'),
(8, 28, 'Howrah'),
(9, 28, 'Jalpaiguri'),
(10, 28, 'Jhargram'),
(11, 28, 'Kalimpong'),
(12, 28, 'Kolkata'),
(13, 28, 'Malda'),
(14, 28, 'Murshidabad'),
(15, 28, 'Nadia'),
(16, 28, 'North 24 Parganas'),
(17, 28, 'Paschim Bardhaman'),
(18, 28, 'Paschim Medinipur'),
(19, 28, 'Purba Bardhaman'),
(20, 28, 'Purba Medinipur'),
(21, 28, 'Purulia'),
(22, 28, 'South 24 Parganas'),
(23, 28, 'Uttar Dinajpur'),
(24, 1, 'Alluri Sitharama Raju'),
(25, 1, 'Anakapalli'),
(26, 1, 'Anantapuramu'),
(27, 1, 'Annamayya'),
(28, 1, 'Bapatla'),
(29, 1, 'Chittoor'),
(30, 1, 'Dr. B.R. Ambedkar Konaseema'),
(31, 1, 'East Godavari'),
(32, 1, 'Eluru'),
(33, 1, 'Guntur'),
(34, 1, 'Kakinada'),
(35, 1, 'Krishna'),
(36, 1, 'Kurnool'),
(37, 1, 'Nandyal'),
(38, 1, 'NTR'),
(39, 1, 'Palnadu'),
(40, 1, 'Parvathipuram Manyam'),
(41, 1, 'Prakasam'),
(42, 1, 'Sri Potti Sriramulu Nellore'),
(43, 1, 'Sri Sathya Sai'),
(44, 1, 'Srikakulam'),
(45, 1, 'Tirupati'),
(46, 1, 'Visakhapatnam'),
(47, 1, 'Vizianagaram'),
(48, 1, 'West Godavari'),
(49, 1, 'YSR Kadapa'),
(50, 2, 'Anjaw'),
(51, 2, 'Changlang'),
(52, 2, 'Dibang Valley'),
(53, 2, 'East Kameng'),
(54, 2, 'East Siang'),
(55, 2, 'Kamle'),
(56, 2, 'Kra Daadi'),
(57, 2, 'Kurung Kumey'),
(58, 2, 'Leparada'),
(59, 2, 'Lohit'),
(60, 2, 'Longding'),
(61, 2, 'Lower Dibang Valley'),
(62, 2, 'Lower Siang'),
(63, 2, 'Lower Subansiri'),
(64, 2, 'Namsai'),
(65, 2, 'Pakke-Kessang'),
(66, 2, 'Papum Pare'),
(67, 2, 'Shi Yomi'),
(68, 2, 'Siang'),
(69, 2, 'Tawang'),
(70, 2, 'Tirap'),
(71, 2, 'Upper Siang'),
(72, 2, 'Upper Subansiri'),
(73, 2, 'West Kameng'),
(74, 2, 'West Siang'),
(75, 3, 'Baksa'),
(76, 3, 'Barpeta'),
(77, 3, 'Biswanath'),
(78, 3, 'Bongaigaon'),
(79, 3, 'Cachar'),
(80, 3, 'Charaideo'),
(81, 3, 'Chirang'),
(82, 3, 'Darrang'),
(83, 3, 'Dhemaji'),
(84, 3, 'Dhubri'),
(85, 3, 'Dibrugarh'),
(86, 3, 'Dima Hasao'),
(87, 3, 'Goalpara'),
(88, 3, 'Golaghat'),
(89, 3, 'Hailakandi'),
(90, 3, 'Hojai'),
(91, 3, 'Jorhat'),
(92, 3, 'Kamrup'),
(93, 3, 'Kamrup Metropolitan'),
(94, 3, 'Karbi Anglong'),
(95, 3, 'Karimganj'),
(96, 3, 'Kokrajhar'),
(97, 3, 'Lakhimpur'),
(98, 3, 'Majuli'),
(99, 3, 'Morigaon'),
(100, 3, 'Nagaon'),
(101, 3, 'Nalbari'),
(102, 3, 'Sivasagar'),
(103, 3, 'Sonitpur'),
(104, 3, 'South Salmara-Mankachar'),
(105, 3, 'Tamulpur'),
(106, 3, 'Tinsukia'),
(107, 3, 'Udalguri'),
(108, 3, 'West Karbi Anglong'),
(109, 4, 'Araria'),
(110, 4, 'Arwal'),
(111, 4, 'Aurangabad'),
(112, 4, 'Banka'),
(113, 4, 'Begusarai'),
(114, 4, 'Bhagalpur'),
(115, 4, 'Bhojpur'),
(116, 4, 'Buxar'),
(117, 4, 'Darbhanga'),
(118, 4, 'East Champaran'),
(119, 4, 'Gaya'),
(120, 4, 'Gopalganj'),
(121, 4, 'Jamui'),
(122, 4, 'Jehanabad'),
(123, 4, 'Kaimur'),
(124, 4, 'Katihar'),
(125, 4, 'Khagaria'),
(126, 4, 'Kishanganj'),
(127, 4, 'Lakhisarai'),
(128, 4, 'Madhepura'),
(129, 4, 'Madhubani'),
(130, 4, 'Munger'),
(131, 4, 'Muzaffarpur'),
(132, 4, 'Nalanda'),
(133, 4, 'Nawada'),
(134, 4, 'Patna'),
(135, 4, 'Purnia'),
(136, 4, 'Rohtas'),
(137, 4, 'Saharsa'),
(138, 4, 'Samastipur'),
(139, 4, 'Saran'),
(140, 4, 'Sheikhpura'),
(141, 4, 'Sheohar'),
(142, 4, 'Sitamarhi'),
(143, 4, 'Siwan'),
(144, 4, 'Supaul'),
(145, 4, 'Vaishali'),
(146, 4, 'West Champaran'),
(147, 5, 'Balod'),
(148, 5, 'Baloda Bazar'),
(149, 5, 'Balrampur'),
(150, 5, 'Bastar'),
(151, 5, 'Bemetara'),
(152, 5, 'Bijapur'),
(153, 5, 'Bilaspur'),
(154, 5, 'Dantewada'),
(155, 5, 'Dhamtari'),
(156, 5, 'Durg'),
(157, 5, 'Gariaband'),
(158, 5, 'Gaurela-Pendra-Marwahi'),
(159, 5, 'Janjgir-Champa'),
(160, 5, 'Jashpur'),
(161, 5, 'Kabirdham'),
(162, 5, 'Kanker'),
(163, 5, 'Kondagaon'),
(164, 5, 'Korba'),
(165, 5, 'Koriya'),
(166, 5, 'Mahasamund'),
(167, 5, 'Mungeli'),
(168, 5, 'Narayanpur'),
(169, 5, 'Raigarh'),
(170, 5, 'Raipur'),
(171, 5, 'Rajnandgaon'),
(172, 5, 'Sukma'),
(173, 5, 'Surajpur'),
(174, 5, 'Surguja'),
(175, 5, 'Sarangarh-Bilaigarh'),
(176, 5, 'Manendragarh-Chirmiri-Bharatpur'),
(177, 5, 'Mohla-Manpur-Ambagarh Chowki'),
(178, 5, 'Khairagarh-Chhuikhadan-Gandai'),
(179, 5, 'Sakti'),
(180, 6, 'North Goa'),
(181, 6, 'South Goa'),
(182, 7, 'Ahmedabad'),
(183, 7, 'Amreli'),
(184, 7, 'Anand'),
(185, 7, 'Aravalli'),
(186, 7, 'Banaskantha'),
(187, 7, 'Bharuch'),
(188, 7, 'Bhavnagar'),
(189, 7, 'Botad'),
(190, 7, 'Chhota Udaipur'),
(191, 7, 'Dahod'),
(192, 7, 'Dang'),
(193, 7, 'Devbhoomi Dwarka'),
(194, 7, 'Gandhinagar'),
(195, 7, 'Gir Somnath'),
(196, 7, 'Jamnagar'),
(197, 7, 'Junagadh'),
(198, 7, 'Kheda'),
(199, 7, 'Kutch'),
(200, 7, 'Mahisagar'),
(201, 7, 'Mehsana'),
(202, 7, 'Morbi'),
(203, 7, 'Narmada'),
(204, 7, 'Navsari'),
(205, 7, 'Panchmahal'),
(206, 7, 'Patan'),
(207, 7, 'Porbandar'),
(208, 7, 'Rajkot'),
(209, 7, 'Sabarkantha'),
(210, 7, 'Surat'),
(211, 7, 'Surendranagar'),
(212, 7, 'Tapi'),
(213, 7, 'Vadodara'),
(214, 7, 'Valsad'),
(215, 8, 'Ambala'),
(216, 8, 'Bhiwani'),
(217, 8, 'Charkhi Dadri'),
(218, 8, 'Faridabad'),
(219, 8, 'Fatehabad'),
(220, 8, 'Gurugram'),
(221, 8, 'Hisar'),
(222, 8, 'Jhajjar'),
(223, 8, 'Jind'),
(224, 8, 'Kaithal'),
(225, 8, 'Karnal'),
(226, 8, 'Kurukshetra'),
(227, 8, 'Mahendragarh'),
(228, 8, 'Nuh'),
(229, 8, 'Palwal'),
(230, 8, 'Panchkula'),
(231, 8, 'Panipat'),
(232, 8, 'Rewari'),
(233, 8, 'Rohtak'),
(234, 8, 'Sirsa'),
(235, 8, 'Sonipat'),
(236, 8, 'Yamunanagar'),
(237, 9, 'Bilaspur'),
(238, 9, 'Chamba'),
(239, 9, 'Hamirpur'),
(240, 9, 'Kangra'),
(241, 9, 'Kinnaur'),
(242, 9, 'Kullu'),
(243, 9, 'Lahaul and Spiti'),
(244, 9, 'Mandi'),
(245, 9, 'Shimla'),
(246, 9, 'Sirmaur'),
(247, 9, 'Solan'),
(248, 9, 'Una'),
(249, 10, 'Bokaro'),
(250, 10, 'Chatra'),
(251, 10, 'Deoghar'),
(252, 10, 'Dhanbad'),
(253, 10, 'Dumka'),
(254, 10, 'East Singhbhum'),
(255, 10, 'Garhwa'),
(256, 10, 'Giridih'),
(257, 10, 'Godda'),
(258, 10, 'Gumla'),
(259, 10, 'Hazaribagh'),
(260, 10, 'Jamtara'),
(261, 10, 'Khunti'),
(262, 10, 'Koderma'),
(263, 10, 'Latehar'),
(264, 10, 'Lohardaga'),
(265, 10, 'Pakur'),
(266, 10, 'Palamu'),
(267, 10, 'Ramgarh'),
(268, 10, 'Ranchi'),
(269, 10, 'Sahebganj'),
(270, 10, 'Seraikela Kharsawan'),
(271, 10, 'Simdega'),
(272, 10, 'West Singhbhum'),
(273, 11, 'Bagalkot'),
(274, 11, 'Ballari'),
(275, 11, 'Belagavi'),
(276, 11, 'Bengaluru Rural'),
(277, 11, 'Bengaluru Urban'),
(278, 11, 'Bidar'),
(279, 11, 'Chamarajanagar'),
(280, 11, 'Chikkaballapur'),
(281, 11, 'Chikkamagaluru'),
(282, 11, 'Chitradurga'),
(283, 11, 'Dakshina Kannada'),
(284, 11, 'Davanagere'),
(285, 11, 'Dharwad'),
(286, 11, 'Gadag'),
(287, 11, 'Hassan'),
(288, 11, 'Haveri'),
(289, 11, 'Kalaburagi'),
(290, 11, 'Kodagu'),
(291, 11, 'Kolar'),
(292, 11, 'Koppal'),
(293, 11, 'Mandya'),
(294, 11, 'Mysuru'),
(295, 11, 'Raichur'),
(296, 11, 'Ramanagara'),
(297, 11, 'Shivamogga'),
(298, 11, 'Tumakuru'),
(299, 11, 'Udupi'),
(300, 11, 'Uttara Kannada'),
(301, 11, 'Vijayapura'),
(302, 11, 'Yadgir'),
(303, 12, 'Alappuzha'),
(304, 12, 'Ernakulam'),
(305, 12, 'Idukki'),
(306, 12, 'Kannur'),
(307, 12, 'Kasaragod'),
(308, 12, 'Kollam'),
(309, 12, 'Kottayam'),
(310, 12, 'Kozhikode'),
(311, 12, 'Malappuram'),
(312, 12, 'Palakkad'),
(313, 12, 'Pathanamthitta'),
(314, 12, 'Thiruvananthapuram'),
(315, 12, 'Thrissur'),
(316, 12, 'Wayanad'),
(317, 13, 'Agar Malwa'),
(318, 13, 'Alirajpur'),
(319, 13, 'Anuppur'),
(320, 13, 'Ashoknagar'),
(321, 13, 'Balaghat'),
(322, 13, 'Barwani'),
(323, 13, 'Betul'),
(324, 13, 'Bhind'),
(325, 13, 'Bhopal'),
(326, 13, 'Burhanpur'),
(327, 13, 'Chhatarpur'),
(328, 13, 'Chhindwara'),
(329, 13, 'Damoh'),
(330, 13, 'Datia'),
(331, 13, 'Dewas'),
(332, 13, 'Dhar'),
(333, 13, 'Dindori'),
(334, 13, 'Guna'),
(335, 13, 'Gwalior'),
(336, 13, 'Harda'),
(337, 13, 'Hoshangabad'),
(338, 13, 'Indore'),
(339, 13, 'Jabalpur'),
(340, 13, 'Jhabua'),
(341, 13, 'Katni'),
(342, 13, 'Khandwa'),
(343, 13, 'Khargone'),
(344, 13, 'Mandla'),
(345, 13, 'Mandsaur'),
(346, 13, 'Morena'),
(347, 13, 'Narsinghpur'),
(348, 13, 'Neemuch'),
(349, 13, 'Panna'),
(350, 13, 'Raisen'),
(351, 13, 'Rajgarh'),
(352, 13, 'Ratlam'),
(353, 13, 'Rewa'),
(354, 13, 'Sagar'),
(355, 13, 'Satna'),
(356, 13, 'Sehore'),
(357, 13, 'Seoni'),
(358, 13, 'Shahdol'),
(359, 13, 'Shajapur'),
(360, 13, 'Sheopur'),
(361, 13, 'Shivpuri'),
(362, 13, 'Sidhi'),
(363, 13, 'Singrauli'),
(364, 13, 'Tikamgarh'),
(365, 13, 'Ujjain'),
(366, 13, 'Umaria'),
(367, 13, 'Vidisha'),
(368, 14, 'Ahmednagar'),
(369, 14, 'Akola'),
(370, 14, 'Amravati'),
(371, 14, 'Aurangabad'),
(372, 14, 'Beed'),
(373, 14, 'Bhandara'),
(374, 14, 'Buldhana'),
(375, 14, 'Chandrapur'),
(376, 14, 'Dhule'),
(377, 14, 'Gadchiroli'),
(378, 14, 'Gondia'),
(379, 14, 'Hingoli'),
(380, 14, 'Jalgaon'),
(381, 14, 'Jalna'),
(382, 14, 'Kolhapur'),
(383, 14, 'Latur'),
(384, 14, 'Mumbai City'),
(385, 14, 'Mumbai Suburban'),
(386, 14, 'Nagpur'),
(387, 14, 'Nanded'),
(388, 14, 'Nandurbar'),
(389, 14, 'Nashik'),
(390, 14, 'Osmanabad'),
(391, 14, 'Palghar'),
(392, 14, 'Parbhani'),
(393, 14, 'Pune'),
(394, 14, 'Raigad'),
(395, 14, 'Ratnagiri'),
(396, 14, 'Sangli'),
(397, 14, 'Satara'),
(398, 14, 'Sindhudurg'),
(399, 14, 'Solapur'),
(400, 14, 'Thane'),
(401, 14, 'Wardha'),
(402, 14, 'Washim'),
(403, 14, 'Yavatmal'),
(404, 15, 'Bishnupur'),
(405, 15, 'Chandel'),
(406, 15, 'Churachandpur'),
(407, 15, 'Imphal East'),
(408, 15, 'Imphal West'),
(409, 15, 'Jiribam'),
(410, 15, 'Kakching'),
(411, 15, 'Kamjong'),
(412, 15, 'Kangpokpi'),
(413, 15, 'Noney'),
(414, 15, 'Pherzawl'),
(415, 15, 'Senapati'),
(416, 15, 'Tamenglong'),
(417, 15, 'Tengnoupal'),
(418, 15, 'Thoubal'),
(419, 15, 'Ukhrul'),
(420, 16, 'East Garo Hills'),
(421, 16, 'East Jaintia Hills'),
(422, 16, 'East Khasi Hills'),
(423, 16, 'North Garo Hills'),
(424, 16, 'Ri Bhoi'),
(425, 16, 'South Garo Hills'),
(426, 16, 'South West Garo Hills'),
(427, 16, 'South West Khasi Hills'),
(428, 16, 'West Garo Hills'),
(429, 16, 'West Jaintia Hills'),
(430, 16, 'West Khasi Hills'),
(431, 17, 'Aizawl'),
(432, 17, 'Champhai'),
(433, 17, 'Hnahthial'),
(434, 17, 'Khawzawl'),
(435, 17, 'Kolasib'),
(436, 17, 'Lawngtlai'),
(437, 17, 'Lunglei'),
(438, 17, 'Mamit'),
(439, 17, 'Saiha'),
(440, 17, 'Saitual'),
(441, 17, 'Serchhip'),
(442, 18, 'Chumoukedima'),
(443, 18, 'Dimapur'),
(444, 18, 'Kiphire'),
(445, 18, 'Kohima'),
(446, 18, 'Longleng'),
(447, 18, 'Mokokchung'),
(448, 18, 'Mon'),
(449, 18, 'Niuland'),
(450, 18, 'Noklak'),
(451, 18, 'Peren'),
(452, 18, 'Phek'),
(453, 18, 'Shamator'),
(454, 18, 'Tuensang'),
(455, 18, 'Tseminyu'),
(456, 18, 'Wokha'),
(457, 18, 'Zunheboto'),
(458, 19, 'Angul'),
(459, 19, 'Balangir'),
(460, 19, 'Balasore'),
(461, 19, 'Bargarh'),
(462, 19, 'Bhadrak'),
(463, 19, 'Boudh'),
(464, 19, 'Cuttack'),
(465, 19, 'Deogarh'),
(466, 19, 'Dhenkanal'),
(467, 19, 'Gajapati'),
(468, 19, 'Ganjam'),
(469, 19, 'Jagatsinghpur'),
(470, 19, 'Jajpur'),
(471, 19, 'Jharsuguda'),
(472, 19, 'Kalahandi'),
(473, 19, 'Kandhamal'),
(474, 19, 'Kendrapara'),
(475, 19, 'Kendujhar'),
(476, 19, 'Khordha'),
(477, 19, 'Koraput'),
(478, 19, 'Malkangiri'),
(479, 19, 'Mayurbhanj'),
(480, 19, 'Nabarangpur'),
(481, 19, 'Nayagarh'),
(482, 19, 'Nuapada'),
(483, 19, 'Puri'),
(484, 19, 'Rayagada'),
(485, 19, 'Sambalpur'),
(486, 19, 'Subarnapur'),
(487, 19, 'Sundargarh'),
(488, 20, 'Amritsar'),
(489, 20, 'Barnala'),
(490, 20, 'Bathinda'),
(491, 20, 'Faridkot'),
(492, 20, 'Fatehgarh Sahib'),
(493, 20, 'Fazilka'),
(494, 20, 'Ferozepur'),
(495, 20, 'Gurdaspur'),
(496, 20, 'Hoshiarpur'),
(497, 20, 'Jalandhar'),
(498, 20, 'Kapurthala'),
(499, 20, 'Ludhiana'),
(500, 20, 'Malerkotla'),
(501, 20, 'Mansa'),
(502, 20, 'Moga'),
(503, 20, 'Muktsar'),
(504, 20, 'Pathankot'),
(505, 20, 'Patiala'),
(506, 20, 'Rupnagar'),
(507, 20, 'Sangrur'),
(508, 20, 'SAS Nagar'),
(509, 20, 'Shaheed Bhagat Singh Nagar'),
(510, 20, 'Tarn Taran'),
(511, 21, 'Ajmer'),
(512, 21, 'Alwar'),
(513, 21, 'Banswara'),
(514, 21, 'Baran'),
(515, 21, 'Barmer'),
(516, 21, 'Bharatpur'),
(517, 21, 'Bhilwara'),
(518, 21, 'Bikaner'),
(519, 21, 'Bundi'),
(520, 21, 'Chittorgarh'),
(521, 21, 'Churu'),
(522, 21, 'Dausa'),
(523, 21, 'Dholpur'),
(524, 21, 'Dungarpur'),
(525, 21, 'Hanumangarh'),
(526, 21, 'Jaipur'),
(527, 21, 'Jaisalmer'),
(528, 21, 'Jalore'),
(529, 21, 'Jhalawar'),
(530, 21, 'Jhunjhunu'),
(531, 21, 'Jodhpur'),
(532, 21, 'Karauli'),
(533, 21, 'Kota'),
(534, 21, 'Nagaur'),
(535, 21, 'Pali'),
(536, 21, 'Pratapgarh'),
(537, 21, 'Rajsamand'),
(538, 21, 'Sawai Madhopur'),
(539, 21, 'Sikar'),
(540, 21, 'Sirohi'),
(541, 21, 'Sri Ganganagar'),
(542, 21, 'Tonk'),
(543, 21, 'Udaipur'),
(544, 22, 'East Sikkim'),
(545, 22, 'North Sikkim'),
(546, 22, 'South Sikkim'),
(547, 22, 'West Sikkim'),
(548, 22, 'Pakyong'),
(549, 22, 'Soreng'),
(550, 23, 'Ariyalur'),
(551, 23, 'Chengalpattu'),
(552, 23, 'Chennai'),
(553, 23, 'Coimbatore'),
(554, 23, 'Cuddalore'),
(555, 23, 'Dharmapuri'),
(556, 23, 'Dindigul'),
(557, 23, 'Erode'),
(558, 23, 'Kallakurichi'),
(559, 23, 'Kancheepuram'),
(560, 23, 'Karur'),
(561, 23, 'Krishnagiri'),
(562, 23, 'Madurai'),
(563, 23, 'Mayiladuthurai'),
(564, 23, 'Nagapattinam'),
(565, 23, 'Namakkal'),
(566, 23, 'Nilgiris'),
(567, 23, 'Perambalur'),
(568, 23, 'Pudukkottai'),
(569, 23, 'Ramanathapuram'),
(570, 23, 'Ranipet'),
(571, 23, 'Salem'),
(572, 23, 'Sivaganga'),
(573, 23, 'Tenkasi'),
(574, 23, 'Thanjavur'),
(575, 23, 'Theni'),
(576, 23, 'Thoothukudi'),
(577, 23, 'Tiruchirappalli'),
(578, 23, 'Tirunelveli'),
(579, 23, 'Tirupathur'),
(580, 23, 'Tiruppur'),
(581, 23, 'Tiruvallur'),
(582, 23, 'Tiruvannamalai'),
(583, 23, 'Tiruvarur'),
(584, 23, 'Vellore'),
(585, 23, 'Viluppuram'),
(586, 23, 'Virudhunagar'),
(587, 24, 'Adilabad'),
(588, 24, 'Bhadradri Kothagudem'),
(589, 24, 'Hyderabad'),
(590, 24, 'Jagtial'),
(591, 24, 'Jangaon'),
(592, 24, 'Jayashankar Bhupalpally'),
(593, 24, 'Jogulamba Gadwal'),
(594, 24, 'Kamareddy'),
(595, 24, 'Karimnagar'),
(596, 24, 'Khammam'),
(597, 24, 'Komaram Bheem'),
(598, 24, 'Mahabubabad'),
(599, 24, 'Mahabubnagar'),
(600, 24, 'Mancherial'),
(601, 24, 'Medak'),
(602, 24, 'Medchal'),
(603, 24, 'Mulugu'),
(604, 24, 'Nagarkurnool'),
(605, 24, 'Nalgonda'),
(606, 24, 'Narayanpet'),
(607, 24, 'Nirmal'),
(608, 24, 'Nizamabad'),
(609, 24, 'Peddapalli'),
(610, 24, 'Rajanna Sircilla'),
(611, 24, 'Ranga Reddy'),
(612, 24, 'Sangareddy'),
(613, 24, 'Siddipet'),
(614, 24, 'Suryapet'),
(615, 24, 'Vikarabad'),
(616, 24, 'Wanaparthy'),
(617, 24, 'Warangal'),
(618, 24, 'Yadadri Bhuvanagiri'),
(619, 25, 'Dhalai'),
(620, 25, 'Gomati'),
(621, 25, 'Khowai'),
(622, 25, 'North Tripura'),
(623, 25, 'Sepahijala'),
(624, 25, 'South Tripura'),
(625, 25, 'Unakoti'),
(626, 25, 'West Tripura'),
(627, 26, 'Agra'),
(628, 26, 'Aligarh'),
(629, 26, 'Prayagraj'),
(630, 26, 'Ambedkar Nagar'),
(631, 26, 'Amethi'),
(632, 26, 'Amroha'),
(633, 26, 'Auraiya'),
(634, 26, 'Azamgarh'),
(635, 26, 'Baghpat'),
(636, 26, 'Bahraich'),
(637, 26, 'Ballia'),
(638, 26, 'Balrampur'),
(639, 26, 'Banda'),
(640, 26, 'Barabanki'),
(641, 26, 'Bareilly'),
(642, 26, 'Basti'),
(643, 26, 'Bhadohi'),
(644, 26, 'Bijnor'),
(645, 26, 'Budaun'),
(646, 26, 'Bulandshahr'),
(647, 26, 'Chandauli'),
(648, 26, 'Chitrakoot'),
(649, 26, 'Deoria'),
(650, 26, 'Etah'),
(651, 26, 'Etawah'),
(652, 26, 'Ayodhya'),
(653, 26, 'Farrukhabad'),
(654, 26, 'Fatehpur'),
(655, 26, 'Firozabad'),
(656, 26, 'Gautam Buddha Nagar'),
(657, 26, 'Ghaziabad'),
(658, 26, 'Ghazipur'),
(659, 26, 'Gonda'),
(660, 26, 'Gorakhpur'),
(661, 26, 'Hamirpur'),
(662, 26, 'Hapur'),
(663, 26, 'Hardoi'),
(664, 26, 'Hathras'),
(665, 26, 'Jalaun'),
(666, 26, 'Jaunpur'),
(667, 26, 'Jhansi'),
(668, 26, 'Kannauj'),
(669, 26, 'Kanpur Dehat'),
(670, 26, 'Kanpur Nagar'),
(671, 26, 'Kasganj'),
(672, 26, 'Kaushambi'),
(673, 26, 'Kheri'),
(674, 26, 'Kushinagar'),
(675, 26, 'Lalitpur'),
(676, 26, 'Lucknow'),
(677, 26, 'Maharajganj'),
(678, 26, 'Mahoba'),
(679, 26, 'Mainpuri'),
(680, 26, 'Mathura'),
(681, 26, 'Mau'),
(682, 26, 'Meerut'),
(683, 26, 'Mirzapur'),
(684, 26, 'Moradabad'),
(685, 26, 'Muzaffarnagar'),
(686, 26, 'Pilibhit'),
(687, 26, 'Pratapgarh'),
(688, 26, 'Raebareli'),
(689, 26, 'Rampur'),
(690, 26, 'Saharanpur'),
(691, 26, 'Sambhal'),
(692, 26, 'Sant Kabir Nagar'),
(693, 26, 'Shahjahanpur'),
(694, 26, 'Shamli'),
(695, 26, 'Shravasti'),
(696, 26, 'Siddharthnagar'),
(697, 26, 'Sitapur'),
(698, 26, 'Sonbhadra'),
(699, 26, 'Sultanpur'),
(700, 26, 'Unnao'),
(701, 26, 'Varanasi'),
(702, 27, 'Almora'),
(703, 27, 'Bageshwar'),
(704, 27, 'Chamoli'),
(705, 27, 'Champawat'),
(706, 27, 'Dehradun'),
(707, 27, 'Haridwar'),
(708, 27, 'Nainital'),
(709, 27, 'Pauri Garhwal'),
(710, 27, 'Pithoragarh'),
(711, 27, 'Rudraprayag'),
(712, 27, 'Tehri Garhwal'),
(713, 27, 'Udham Singh Nagar'),
(714, 27, 'Uttarkashi'),
(715, 29, 'Nicobar'),
(716, 29, 'North and Middle Andaman'),
(717, 29, 'South Andaman'),
(718, 30, 'Chandigarh'),
(719, 31, 'Dadra and Nagar Haveli'),
(720, 31, 'Daman'),
(721, 31, 'Diu'),
(722, 32, 'Central Delhi'),
(723, 32, 'East Delhi'),
(724, 32, 'New Delhi'),
(725, 32, 'North Delhi'),
(726, 32, 'North East Delhi'),
(727, 32, 'North West Delhi'),
(728, 32, 'Shahdara'),
(729, 32, 'South Delhi'),
(730, 32, 'South East Delhi'),
(731, 32, 'South West Delhi'),
(732, 32, 'West Delhi'),
(733, 33, 'Anantnag'),
(734, 33, 'Bandipora'),
(735, 33, 'Baramulla'),
(736, 33, 'Budgam'),
(737, 33, 'Doda'),
(738, 33, 'Ganderbal'),
(739, 33, 'Jammu'),
(740, 33, 'Kathua'),
(741, 33, 'Kishtwar'),
(742, 33, 'Kulgam'),
(743, 33, 'Kupwara'),
(744, 33, 'Poonch'),
(745, 33, 'Pulwama'),
(746, 33, 'Rajouri'),
(747, 33, 'Ramban'),
(748, 33, 'Reasi'),
(749, 33, 'Samba'),
(750, 33, 'Shopian'),
(751, 33, 'Srinagar'),
(752, 33, 'Udhampur'),
(753, 34, 'Kargil'),
(754, 34, 'Leh'),
(755, 35, 'Lakshadweep'),
(756, 36, 'Karaikal'),
(757, 36, 'Mahe'),
(758, 36, 'Puducherry'),
(759, 36, 'Yanam');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `dob` datetime NOT NULL,
  `address` text NOT NULL,
  `state` varchar(255) NOT NULL,
  `distric` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `subdepartment` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `employee_type` varchar(255) NOT NULL,
  `joining_date` datetime NOT NULL,
  `salary` varchar(255) NOT NULL,
  `work_location` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `id_proof_type` varchar(255) DEFAULT NULL,
  `id_proof_number` varchar(255) DEFAULT NULL,
  `id_proof_doccument` varchar(255) DEFAULT NULL,
  `address_proof` varchar(255) DEFAULT NULL,
  `address_proof_document` varchar(255) DEFAULT NULL,
  `collage_name` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `course_document` varchar(255) DEFAULT NULL,
  `internship_duration` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `name`, `email`, `phone`, `image`, `gender`, `dob`, `address`, `state`, `distric`, `city`, `pincode`, `company_name`, `department`, `subdepartment`, `designation`, `employee_type`, `joining_date`, `salary`, `work_location`, `experience`, `id_proof_type`, `id_proof_number`, `id_proof_doccument`, `address_proof`, `address_proof_document`, `collage_name`, `course`, `course_document`, `internship_duration`, `status`) VALUES
(101, 'ITC101', 'Joti Das', 'p3xf2qtiq7@yzcalo.com', '6789098765', '1773222681_images (7).jpg', 'Female', '1998-06-18 00:00:00', 'rghjjhgfds', '28', '12', 'English Bazar', 345678, 'ITC', '5', '18', 'teamlead', 'Part Time', '2026-03-26 00:00:00', '27000', 'ytdghj', '3', NULL, NULL, '1773222681_internship_certificate (14).pdf', NULL, '1773222681_internship_certificate (5).pdf', NULL, NULL, NULL, NULL, 1),
(102, 'turain102', 'Ritik Dey', 'y2tgf@dollicons.com', '6789876543', '1773227897_download (3).jpg', 'Male', '2000-10-31 00:00:00', 'sdfghjkllkjhgfdafghjk', '11', '283', 'sdfghjhgfd', 456787, 'turain', '2', '6', 'intern', 'Full Time', '2025-10-28 00:00:00', '10000', 'uytfdcghj', '0', NULL, NULL, '1773227897_internship_certificate (18).pdf', NULL, '1773227897_internship_certificate (18).pdf', 'htdsxcvbnk', 'fghjhgf', '1773227897_internship_certificate (18).pdf', '6 Months', 1),
(103, 'TCS103', 'Joti Das', 'k4jvs@dollicons.com', '6789098765', '1773233676_images (7).jpg', 'Female', '2026-03-11 00:00:00', 'rghjjhgfds', '23', '560', 'English Bazar', 345678, 'TCS', '5', '16', 'employee', 'Full Time', '2025-12-30 00:00:00', '38000', 'ytdghj', '2', NULL, NULL, '1773233676_1771654882_69994ee2073fe (1).pdf', NULL, '1773233676_1771654882_69994ee2073fe (1).pdf', NULL, NULL, NULL, NULL, 1),
(104, 'PWC104', 'Raja Shing', 'wsl7v@dollicons.com', '9876543456', '1773234649_images (4).jpg', 'Male', '2003-05-08 00:00:00', 'ertyuikl;lkjhgfd', '10', '259', 'oiuytreert', 765434, 'PWC', '8', '26', NULL, 'Full Time', '2025-07-17 00:00:00', '54899', 'ertyuijhgf', '5', NULL, NULL, '1773234649_internship_certificate (1).pdf', NULL, '1773234649_internship_certificate (1).pdf', NULL, NULL, NULL, NULL, 1),
(105, 'turain105', 'Diipti Shen', '4qrbi@dollicons.com', '9876543456', '1773235844_images (3).jpg', 'Female', '1993-02-15 00:00:00', 'rtyuilkjhgfdwertyuk', '9', '246', 'sdtyuklmngf', 456789, 'turain', '6', '21', NULL, 'Part Time', '2012-10-18 00:00:00', '67654', 'erthgfdsd', '6', NULL, NULL, '1773235844_1772689198_1771404536_21d091383c24116c84b3c256f3ae2d53 (5).pdf', NULL, '1773235844_internship_certificate (14).pdf', NULL, NULL, NULL, NULL, 1),
(106, 'TCS-106', 'Soumili Halder', 'b2t7v@dollicons.com', '8765445678', '1773294538_images (2).jpg', 'Female', '1999-05-11 00:00:00', 'wertyuiol;;lkuytr', '10', '260', 'werghhg', 456789, 'TCS', '1', '3', 'employee', 'Full Time', '2022-06-15 00:00:00', '27000', 'sdfghjk', '4', 'Voter ID', '4567ujhgf56', '1773294538_Project Management System (1).pdf', 'Bank Passbook', '1773294538_internship_certificate (17).pdf', NULL, NULL, NULL, NULL, 1),
(107, 'ITC-107', 'sdfghj erty', 'zx31i@dollicons.com', '7654334567', '1773294895_images (6).jpg', 'Male', '1993-06-09 00:00:00', 'qwertghj', '12', '314', 'wdfv', 345678, 'ITC', '6', '20', NULL, 'Full Time', '2025-12-16 00:00:00', '67654', 'erthgfdsd', '2', 'Voter ID', 'asdfghm65432wdfvb', '1773294895_internship_certificate (17).pdf', 'Electricity Bill', '1773294895_internship_certificate (17).pdf', NULL, NULL, NULL, NULL, 1),
(108, 'CTS-108', 'sdfgklkjhg rtyujhg', 'davom85663@faxzu.com', '8765434562', '1773295363_download (2).jpg', 'Female', '1988-10-18 00:00:00', 'rtyuklkjhgfthj', '11', '283', 'wertyuimngfds', 876543, 'CTS', '8', '26', NULL, 'Full Time', '2018-10-12 00:00:00', '53333', 'ertyuilkjhgf', '5', 'Aadhar Card', '34567898765433', '1773295363_internship_certificate (13).pdf', 'Aadhar Card', '1773295363_internship_certificate (13).pdf', NULL, NULL, NULL, NULL, 1),
(109, 'CTS-109', 'werg ergrg', 'gxf4jatx0j@lnovic.com', '8765434567', '1773295739_download (4).jpg', 'Female', '1994-02-22 00:00:00', 'wertyuio', '31', '720', 'New Town', 345678, 'CTS', '2', '7', 'teamlead', 'Part Time', '2025-12-17 00:00:00', '76000', 'wefgbbfddf', '7', 'Aadhar Card', '598765434567', '1773295739_internship_certificate (9).pdf', 'Electricity Bill', '1773295739_internship_certificate (1).pdf', NULL, NULL, NULL, NULL, 1),
(110, 'TCS-110', 'erth wertyuil', 'giqokymi@forexzig.com', '7654323456', '1773295936_images (7).jpg', 'Female', '2002-10-22 00:00:00', 'gfdsertyhjkmhgfd', '7', '191', 'dfv sdfghjk', 456789, 'TCS', '3', '9', 'intern', 'Full Time', '2025-12-23 00:00:00', '29800', 'asdfghjkjhgfd', '0', 'PAN Card', 'erty45634567hgfds', '1773295936_internship_certificate (9).pdf', 'Electricity Bill', '1773295936_internship_certificate (1).pdf', 'htdsxcvbnk', 'vdwsd', '1773295936_internship_certificate (22).pdf', '6 Months', 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_12_083409_create_logs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `project_title` text NOT NULL,
  `project_document` varchar(255) DEFAULT NULL,
  `project_department` varchar(255) NOT NULL,
  `technology` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `noe` int(11) NOT NULL COMMENT 'number of employees',
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `company_name`, `project_title`, `project_document`, `project_department`, `technology`, `start_date`, `end_date`, `noe`, `description`, `created_at`, `status`) VALUES
(1, 'Turain', 'Turain Internship Management System', '1773297078_internship_certificate (8).pdf', '1', 'laravel', '2026-02-02 00:00:00', '2026-03-25 00:00:00', 5, 'jytresxchjnb jgfdtd ytrdtygfvj uytffguiuhgvhj uytrrtfguhb uytfdfygfguhb asdfghjjhgr werthjmngf werghnbfd vfdwq efghnbvds . werfghjhgfd wertyjgfds ergbfd kgbjk jgfdxcvhj jbvbnm fdfguij jhgvbk mnbv uyfghj uytffgh \r\nuytfgh gfhjk iuyfvhj ugcvbe fgbgfrew gcvhj vbfewdfvj vbjk', '2026-03-12 00:00:00', 1),
(3, 'rghhgf', 'tfdcvghtrd trdxcghn xdertg jyfvbn', '1773298474_internship_certificate (20).pdf', '2', 'laravel', '2026-03-01 00:00:00', '2026-05-10 00:00:00', 4, 'rthhgfx bgfdsarth srtyhjnbvcxsd  cdrtyjnb fghjjuytrdx dfghnbvc dfgbhjytd csertyjnb dfghnbvcx', '2026-03-12 00:00:00', 0),
(4, 'sdfghgfds', 'sdfghjh ssdfghjmnbvcx', '1773298543_internship_certificate (4).pdf', '7', 'photoshop', '2026-03-04 00:00:00', '2026-03-14 00:00:00', 3, 'awertyhj wertyhjm sertjjhgfd dfghjkytrscgh dhjfjnbv erthjnbx  erthjnbvx  dbvc', '2026-03-12 00:00:00', 2),
(9, 'sdfgfdsasdf', 'yresdfyuio', '1773300858_1771408422_2bc5c17695484ae627313cb72ecc06ce (1).pdf', '4', 'werftgyhjhgfddfbn', '2025-12-24 00:00:00', '2026-04-28 00:00:00', 4, 'sdrftyujikm sertyujmn ertyujhgfdx ertyjhgfdfghjm ertyuijhgfgn', '2026-03-12 00:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('eYSOMCvw7AIndWCBCQD8pyxdNKOkxitvWXTtI13u', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQVdJdG1YRDdQWnhvSHNEdktVMU9hREYyQ3FNeFlTSHRQNjg1dVIxciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdXBlcmFkbWluL1Byb2plY3QvbGlzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NzoidXNlcl9pZCI7aToxO3M6OToidXNlcl9yb2xlIjtzOjEwOiJzdXBlcmFkbWluIjt9', 1773304358);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(1, 'Andhra Pradesh'),
(2, 'Arunachal Pradesh'),
(3, 'Assam'),
(4, 'Bihar'),
(5, 'Chhattisgarh'),
(6, 'Goa'),
(7, 'Gujarat'),
(8, 'Haryana'),
(9, 'Himachal Pradesh'),
(10, 'Jharkhand'),
(11, 'Karnataka'),
(12, 'Kerala'),
(13, 'Madhya Pradesh'),
(14, 'Maharashtra'),
(15, 'Manipur'),
(16, 'Meghalaya'),
(17, 'Mizoram'),
(18, 'Nagaland'),
(19, 'Odisha'),
(20, 'Punjab'),
(21, 'Rajasthan'),
(22, 'Sikkim'),
(23, 'Tamil Nadu'),
(24, 'Telangana'),
(25, 'Tripura'),
(26, 'Uttar Pradesh'),
(27, 'Uttarakhand'),
(28, 'West Bengal'),
(29, 'Andaman and Nicobar Islands'),
(30, 'Chandigarh'),
(31, 'Dadra and Nagar Haveli and Daman and Diu'),
(32, 'Delhi'),
(33, 'Jammu and Kashmir'),
(34, 'Ladakh'),
(35, 'Lakshadweep'),
(36, 'Puducherry');

-- --------------------------------------------------------

--
-- Table structure for table `subdepartment`
--

CREATE TABLE `subdepartment` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `subdepartment_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subdepartment`
--

INSERT INTO `subdepartment` (`id`, `department_id`, `subdepartment_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Software Developer', NULL, NULL),
(2, 1, 'Senior Software Developer', NULL, NULL),
(3, 1, 'Backend Developer', NULL, NULL),
(4, 1, 'Full Stack Developer', NULL, NULL),
(5, 2, 'Web Developer', NULL, NULL),
(6, 2, 'Frontend Developer', NULL, NULL),
(7, 2, 'Laravel Developer', NULL, NULL),
(8, 2, 'PHP Developer', NULL, NULL),
(9, 3, 'Android Developer', NULL, NULL),
(10, 3, 'iOS Developer', NULL, NULL),
(11, 3, 'Flutter Developer', NULL, NULL),
(12, 3, 'React Native Developer', NULL, NULL),
(13, 4, 'UI Designer', NULL, NULL),
(14, 4, 'UX Designer', NULL, NULL),
(15, 4, 'Product Designer', NULL, NULL),
(16, 5, 'SEO Executive', NULL, NULL),
(17, 5, 'Digital Marketing Executive', NULL, NULL),
(18, 5, 'Social Media Manager', NULL, NULL),
(19, 5, 'Content Marketer', NULL, NULL),
(20, 6, 'HR Executive', NULL, NULL),
(21, 6, 'HR Manager', NULL, NULL),
(23, 7, 'Graphic Designer', NULL, NULL),
(24, 7, 'Motion Graphic Designer', NULL, NULL),
(25, 7, 'Creative Designer', NULL, NULL),
(26, 8, 'Project Manager', NULL, NULL),
(27, 8, 'Project Executive', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `employee_id`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'superadmin', 'superadmin@gmail.com', NULL, '$2y$12$ycBvHeXwUmoYKvcYuSISJuhVRPwWbgp/KRcswY.GO/BnoSpaRLp7K', 'superadmin', NULL, NULL, '2026-03-04 20:31:05', '2026-03-04 20:31:05', 1),
(2, 'Rity Das', 'p3xf2qtiq7@yzcalo.com', NULL, '$2y$12$Uddj2hir6gEBOWD1gO/5peIgzED0fHzvzkHEhOltrgXU1KKWAZvwe', 'teamlead', 'ITC101', NULL, '2026-03-11 04:21:22', '2026-03-11 06:59:28', 1),
(3, 'Ritik Dey', 'y2tgf@dollicons.com', NULL, '$2y$12$gZKjzpYybxDBkP/83NtuLeWgfT9w09Xyz7A8z2FSF3U2aRPFQkqEK', 'intern', 'turain102', NULL, '2026-03-11 05:48:18', '2026-03-11 06:59:52', 1),
(4, 'Joti Das', 'k4jvs@dollicons.com', NULL, '$2y$12$s7JszcwaxixLI1kpMn84p.7qCjAngtUQTvo/QbAK8P6OmxxB4WJcK', 'employee', 'TCS103', NULL, '2026-03-11 07:24:36', '2026-03-11 07:36:43', 1),
(5, 'Raja Shing', 'wsl7v@dollicons.com', NULL, '$2y$12$89w6X.XUV.iEe4pNNQbdt.XN77rTTTYy.6A5cMn0v/IyIsxM1DTYq', 'projectmanager', 'PWC104', NULL, '2026-03-11 07:40:50', '2026-03-11 07:57:55', 1),
(6, 'Diipti Shen', '4qrbi@dollicons.com', NULL, '$2y$12$FIb/MQTJgm/Vjoyag2d4gee0mqh/F9zb9e0NO4KJvtnpe6nm9iiqa', 'hr', 'turain105', NULL, '2026-03-11 08:00:44', '2026-03-12 00:01:23', 1),
(7, 'Soumili Halder', 'b2t7v@dollicons.com', NULL, '$2y$12$YS.DLN8s0SNJ.gEDsrQaVesaQO7nJkJlTlnlRthr4ru1qbbLiDFW.', 'employee', 'employee-106', NULL, '2026-03-12 00:18:58', '2026-03-12 00:18:58', 1),
(8, 'sdfghj erty', 'zx31i@dollicons.com', NULL, '$2y$12$w1P0UfHBM7z2NYqJFZ2pKujrerR3XGh6JbWxGoz7bZp0vvpvD842S', 'hr', 'hr-107', NULL, '2026-03-12 00:24:55', '2026-03-12 00:24:55', 1),
(9, 'sdfgklkjhg rtyujhg', 'davom85663@faxzu.com', NULL, '$2y$12$8pJJX0SMGslkM06s53oMGuc1MKXPr0/1C7Hqbu3GF6GNGAhBhLQiu', 'projectmanager', 'projectmanager-108', NULL, '2026-03-12 00:32:43', '2026-03-12 00:32:43', 1),
(10, 'werg ergrg', 'gxf4jatx0j@lnovic.com', NULL, '$2y$12$7KcatrJeuLFTeK4GZxQBYuWPL8kpFJ9hGLFmmRQofNE1nQUMPzstq', 'teamlead', 'teamlead-109', NULL, '2026-03-12 00:39:00', '2026-03-12 00:39:00', 1),
(11, 'erth wertyuil', 'giqokymi@forexzig.com', NULL, '$2y$12$9oc7m.08DqVpZ1myEMw62Ove2ez4vdWTcdeXUBDFDShHi.Qa84eeS', 'intern', 'intern-110', NULL, '2026-03-12 00:42:16', '2026-03-12 00:42:16', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `companis`
--
ALTER TABLE `companis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subdepartment`
--
ALTER TABLE `subdepartment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companis`
--
ALTER TABLE `companis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=760;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `subdepartment`
--
ALTER TABLE `subdepartment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subdepartment`
--
ALTER TABLE `subdepartment`
  ADD CONSTRAINT `subdepartment_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
