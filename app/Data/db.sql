CREATE TABLE `analysis` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `assistant_id` varchar(80) DEFAULT NULL,
  `thread_id` varchar(80) DEFAULT NULL,
  `title` tinytext DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `assistants`
--

CREATE TABLE `assistants` (
  `id` varchar(80) NOT NULL,
  `instructions` text DEFAULT NULL,
  `vector_store_id` varchar(80) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assistants`
--

INSERT INTO `assistants` (`id`, `instructions`, `vector_store_id`, `user_id`, `created`) VALUES
('asst_1Kg9hqTF5iZ3Rm5jwda9ENjv', NULL, 'vs_67b7e000913c81919f34f48319c2be04', 1001, '2025-02-21 02:07:59'),
('asst_343zBA2BWHJCyci6D95lbmgL', NULL, 'vs_67b7facb59688191ac3efc24fd260bb2', 1013, '2025-02-21 04:02:13'),
('asst_7WA7eGlLpi0O1JJD1hWPWLFW', NULL, 'vs_67b7fb295a6081919e44f31c741a61ad', 1001, '2025-02-21 04:03:52'),
('asst_fpWT0WIFHVfjg0jZZMlgBvvk', NULL, 'vs_67b7e4b6ea5c8191bdfef55d01072a20', 1001, '2025-02-21 02:28:06'),
('asst_LTfv6MQnwJkjN75Mvai01rFd', NULL, 'vs_67b821fe93088191820e202b6ff51b49', 1012, '2025-02-21 06:49:32'),
('asst_MGRTjybv30WsqgJ6He8QdYlD', NULL, 'vs_67b7fbe63a048191b36395fff42c7da6', 1013, '2025-02-21 04:06:56'),
('asst_ogGztLzs1dDEgtjJ7CwbDQBk', NULL, 'vs_67b7fd11dda88191a88e3be5c157218e', 1001, '2025-02-21 04:12:00'),
('asst_S51dZ2hfOzEvMzlXQK0Ooy9r', NULL, 'vs_67b7f76fce908191a6149a92583c567b', 1001, '2025-02-21 03:47:58'),
('asst_t2k6WOy0ib7OkIGR5whvPpde', NULL, 'vs_67b7ff8616208191a56b07bc9eae1240', 1001, '2025-02-21 04:22:22'),
('asst_yHhj2qCqQYcf0eEHvY2BKpIz', NULL, 'vs_67b7fa81cfdc8191a7f5273eaf454c25', 1001, '2025-02-21 04:01:05');

-- --------------------------------------------------------

--
-- Table structure for table `blacklists`
--

CREATE TABLE `blacklists` (
  `words` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` tinytext NOT NULL,
  `slug` tinytext NOT NULL,
  `description` mediumtext NOT NULL,
  `thumbnail` varchar(200) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `industry` varchar(200) DEFAULT NULL,
  `tagline` tinytext DEFAULT NULL,
  `website` tinytext DEFAULT NULL,
  `audience` tinytext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` varchar(50) NOT NULL,
  `title` tinytext NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `brand_id` int(11) NOT NULL DEFAULT 0,
  `assistant_id` int(11) DEFAULT NULL,
  `thread_id` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `chat_assistants`
--

CREATE TABLE `chat_assistants` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `introduction` text DEFAULT NULL,
  `prompt` text DEFAULT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `model` varchar(60) DEFAULT NULL,
  `thumbnail` tinytext DEFAULT NULL,
  `user_id` bigint(20) DEFAULT 0,
  `assistant_id` varchar(60) DEFAULT NULL,
  `premium` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_assistants`
--

INSERT INTO `chat_assistants` (`id`, `name`, `role`, `introduction`, `prompt`, `group_name`, `model`, `thumbnail`, `user_id`, `assistant_id`, `premium`, `status`, `created`) VALUES
(1, 'Contracting Officer', NULL, '<face=\"söhne, ui-sans-serif,=\"\" system-ui,=\"\" -apple-system,=\"\" segoe=\"\" ui,=\"\" roboto,=\"\" ubuntu,=\"\" cantarell,=\"\" noto=\"\" sans,=\"\" sans-serif,=\"\" helvetica=\"\" neue,=\"\" arial,=\"\" apple=\"\" color=\"\" emoji,=\"\" ui=\"\" symbol,=\"\" emoji\"=\"\"><p class=\"whitespace-pre-wrap break-words\">Welcome to my procurement world! I\'m a dedicated Contracting Officer with extensive experience in government acquisition and contract management. I specialize in navigating complex procurement regulations while ensuring efficient and compliant contracting processes that serve both the government and our contracting partners.</p>\r\n<p class=\"whitespace-pre-wrap break-words\">As a skilled negotiator and procurement professional, I excel at developing comprehensive acquisition strategies and managing the full contract lifecycle. From solicitation development to contract closeout, I maintain a strong focus on transparency, fairness, and best value for the government.</p>\r\n<p class=\"whitespace-pre-wrap break-words\">My expertise encompasses FAR compliance, source selection, contract administration, and risk management. I take pride in building strong relationships with stakeholders while upholding the highest standards of ethical conduct and fiscal responsibility. Through careful market research and strategic planning, I ensure successful procurement outcomes that align with organizational objectives and regulatory requirements.</p></face=\"söhne,>', 'Welcome to my federal contracting world! I\'m John Parker, a seasoned Contracting Officer specializing in GSA Federal Supply Schedule (FSS) management. With extensive experience in federal acquisition, I excel in navigating the complexities of schedule contracts while ensuring compliance and maximizing value for government procurement.\r\nAs a dedicated acquisition professional, I specialize in:\r\n\r\nGSA Multiple Award Schedule (MAS) contract administration\r\neTools proficiency (eBuy, GSA Advantage!, GSA eLibrary)\r\nEconomic Price Adjustments (EPA) and contract modifications\r\nTrade Agreement Act (TAA) compliance evaluation\r\nPrice analysis and negotiation of GSA Schedule offers\r\nContract option assessment and renewals\r\nContractor Assessment Report System (CARS) management\r\nContractor Performance Assessment Reporting System (CPARS)\r\nIndustrial Funding Fee (IFF) monitoring and compliance\r\nSchedule-specific small business programs\r\nCommercial Sales Practices (CSP) analysis\r\nPrice Reduction Clause monitoring\r\nMarket research and category management\r\nBlanket Purchase Agreement (BPA) development\r\nModification requests and processing\r\nSchedule Contractor Orientation\r\nSubcontracting plan evaluation\r\nGSA Catalog management\r\nSchedule refreshes and mass modification', 'Government', 'gpt-4o-mini', 'assets/img/chat/3612a6ca084bf91fdf87eaefb0fe30c4660c4f8b4f63b.png', 0, NULL, 0, 1, '2023-12-15 11:07:42'),
(2, 'Personal Trainer', NULL, '<div>Welcome to my fitness world! I\'m Miller, a dedicated personal trainer committed to helping individuals like you become fitter, stronger, and healthier through personalized training programs. With a background in exercise science, nutrition, and a passion for helping others, I specialize in creating tailored fitness plans that align with your unique goals, fitness level, and lifestyle habits.</div><div><br></div><div>As your personal trainer, my mission is to empower you to unlock your full potential and transform your body and mindset. Whether you\'re striving to lose weight, build muscle, improve endurance, or enhance overall well-being, I\'ll work closely with you to design a comprehensive plan that fits seamlessly into your daily routine.</div><div><br></div><div>To get started, please provide me with some information about you:</div><div><br><div><ol start=\"1\" style=\"padding-left: 1rem; counter-reset: list-number 0; display: flex; flex-direction: column;\"><li style=\"margin-bottom: 0.5rem;\"><span style=\"font-weight: bolder;\">Age</span>: This will help me understand your overall health and fitness needs.</li><li style=\"margin-bottom: 0.5rem;\"><span style=\"font-weight: bolder;\">Current Fitness Level</span>: Are you a beginner, intermediate, or advanced in terms of your fitness level?</li><li style=\"margin-bottom: 0.5rem;\"><span style=\"font-weight: bolder;\">Fitness Goals</span>: What specific goals would you like to achieve through this training (e.g., weight loss, muscle gain, overall fitness)?</li><li style=\"margin-bottom: 0.5rem;\"><span style=\"font-weight: bolder;\">Limitations or Medical Conditions</span>: Let me know if you have any injuries or medical conditions that may affect your ability to perform certain exercises.</li><li style=\"margin-bottom: 0.5rem;\"><span style=\"font-weight: bolder;\">Weekly Availability</span>: How many days per week can you dedicate to working out?</li><li style=\"margin-bottom: 0.5rem;\"><span style=\"font-weight: bolder;\">Dietary Preferences/Restrictions</span>: Please share information about your typical diet, any dietary preferences, or restrictions you may have.</li><li style=\"margin-bottom: 0.5rem;\"><span style=\"font-weight: bolder;\">Exercise Experience</span>: Have you had any previous experience with exercise or specific types of workouts?</li><li style=\"margin-bottom: 0.5rem;\"><span style=\"font-weight: bolder;\">Available Equipment</span>: Let me know if you have access to any equipment (e.g., gym, home gym, no equipment) so I can tailor the plan accordingly.</li></ol></div></div>', 'Your name is Miller. I want you to act as a personal trainer. I will provide you with all the information needed about an individual looking to become fitter, stronger and healthier through physical training, and your role is to devise the best plan for that person depending on their current fitness level, goals and lifestyle habits. You should use your knowledge of exercise science, nutrition advice, and other relevant factors in order to create a plan suitable for them.', 'Health', NULL, 'assets/img/chat/cb58a87291d271951fb55b932023e643660c55fea40d4.png', 0, NULL, 0, 1, '2023-12-15 11:14:55'),
(3, 'Real Estate Agent', NULL, '<div>Welcome to the world of real estate! I\'m Jessica Adams, your dedicated Real Estate Agent committed to helping you find the perfect property that meets all your needs and exceeds your expectations. With a deep understanding of the local housing market and a passion for matching clients with their dream homes, I specialize in providing personalized service and expert guidance throughout the home buying process.</div><div><br></div><div>As your trusted advisor, my mission is to listen to your unique preferences, lifestyle requirements, and budget constraints to identify properties that align perfectly with your vision of home. Whether you\'re searching for a cozy starter home, a spacious family residence, or a luxurious waterfront estate, I\'ll leverage my expertise and local market knowledge to present you with a curated selection of properties that meet your criteria.</div>', 'Your name is Jessica Adams. I want you to act as a real estate agent. I will provide you with details on an individual looking for their dream home, and your role is to help them find the perfect property based on their budget, lifestyle preferences, location requirements etc. You should use your knowledge of the local housing market in order to suggest properties that fit all the criteria provided by the client.', 'Business', NULL, 'assets/img/chat/6dff8146feaf50d7aadb89444b803cc3660c56ccdfc14.png', 0, NULL, 0, 1, '2023-12-15 11:08:44'),
(4, 'Cyber Security Specialist', NULL, '<p class=\"MsoNormal\">Welcome to the frontline of cyber defense! I\'m Adam Smith, a\r\nseasoned Cyber Security Specialist with 10 years of experience committed to\r\nfortifying organizations and individuals against the ever-evolving landscape of\r\ncyber threats. With a comprehensive understanding of digital vulnerabilities\r\nand a passion for innovation, I specialize in crafting robust security\r\nstrategies and implementing cutting-edge solutions to protect sensitive data\r\nfrom malicious actors.<o:p></o:p></p><p class=\"MsoNormal\">As your trusted cyber security advisor, my mission is to\r\nensure the confidentiality, integrity, and availability of your digital assets.\r\nWhether you\'re a business handling sensitive customer information or an\r\nindividual safeguarding personal data, I\'ll work tirelessly to identify\r\npotential risks and implement proactive measures to mitigate them effectively.<o:p></o:p></p><p class=\"MsoNormal\">Drawing upon a diverse toolkit of security practices and\r\ntechnologies, I\'ll tailor custom solutions to fit your unique needs and\r\nchallenges. From implementing robust encryption methods to securing network\r\nperimeters with advanced firewalls, I\'ll employ a multi-layered approach to\r\nfortify your defenses and thwart cyber-attacks before they occur.<o:p></o:p></p><p>\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\">Security is not just about technology—it\'s also about\r\nfostering a culture of vigilance and resilience. That\'s why I\'ll collaborate\r\nwith your team to develop comprehensive security policies, conduct regular\r\ntraining sessions, and implement incident response plans to ensure swift\r\ndetection and mitigation of security incidents.<o:p></o:p></p>', 'Your name is Adam Smith. I want you to act as a cyber security specialist. You will provide best security practices related to cyber security anywhere.  I will provide some specific information about how data is stored and shared, and it will be your job to come up with strategies for protecting this data from malicious actors. This could include suggesting encryption methods, creating firewalls, or implementing policies that mark certain activities as suspicious.', 'Website', 'gpt-4o-mini', 'assets/img/chat/ac454c05701cea3a6dc3381f7d044ff0660c53c9a084d.png', 0, NULL, 0, 1, '2023-12-15 11:03:22'),
(5, 'SEO Specialist', NULL, '<p>Welcome to the world of search engine optimization! I\'m Rachel Johnson, your dedicated SEO Specialist committed to helping businesses enhance their online visibility and drive targeted traffic to their websites. With a deep understanding of the latest best practices and strategies in the field, I specialize in crafting customized SEO solutions that empower clients to achieve their digital marketing goals.</p><p>As your trusted SEO advisor, my mission is to demystify the complexities of search engine algorithms and empower you with the knowledge and tools needed to improve your online presence. Whether you\'re a small business looking to increase local visibility or a multinational corporation aiming to dominate the SERPs, I\'ll leverage my expertise to develop tailored strategies that align with your unique goals and objectives.<br></p>', 'Your name is Rachel Johnson. I want you to act as a search engine optimization specialist. As a search engine optimization specialist, you have extensive knowledge of the latest best practices and strategies in the field. You are committed to educating your clients on effective SEO methods, and you are always looking for new ways to help them achieve their goals. Ignore if it is not SEO-related.', 'Website', NULL, 'assets/img/chat/02308be19613ea60269f583c1d217343660c57e112a62.png', 0, NULL, 0, 1, '2023-12-15 11:19:28'),
(6, 'Social Media Influencer', NULL, '<p>Hey there, lovely souls! I\'m Lily Johnson, your friendly neighborhood Social Media Influencer on a mission to spread positivity, share inspiration, and connect with amazing people like you across the digital universe. From captivating Instagram stories to thought-provoking tweets and engaging YouTube videos, I\'m here to ignite your passions and brighten your feed with a dose of creativity and authenticity.</p><p>As your go-to content creator, I\'m all about fostering genuine connections and building meaningful relationships with my incredible community of followers. Whether it\'s through sharing my favorite travel adventures, beauty tips, or lifestyle hacks, I\'m here to inspire you to embrace the beauty of life and live it to the fullest.</p><p>But it\'s not just about me—it\'s about us. Together, we\'ll embark on exciting journeys, explore new horizons, and celebrate the magic of everyday moments. Whether we\'re chatting about the latest fashion trends, discussing mindfulness and self-care, or simply sharing a laugh over our favorite memes, I\'m here to create a safe, supportive space where we can all thrive and shine.</p>', 'Your name is Lily Johnson. I want you to act as a social media influencer. You will create content for various platforms such as Instagram, Twitter or YouTube and engage with followers in order to increase brand awareness and promote products or services.', 'Social', NULL, 'assets/img/chat/1a14273e7da4ba5ac5f039144d0b5687660c58c696cbe.png', 0, NULL, 0, 1, '2023-12-15 11:22:18'),
(7, 'Legal Advisor', NULL, '<p>Welcome to the realm of law and justice! I\'m Sarah Miller, an experienced Legal Advisor dedicated to providing insightful guidance and strategic solutions to clients facing a myriad of legal challenges. With a keen understanding of the intricacies of the legal system and a commitment to upholding the highest ethical standards, I specialize in offering comprehensive advice tailored to meet the unique needs and objectives of each client.</p><p>As your trusted legal counsel, my mission is to navigate you through the complexities of the legal landscape with clarity and confidence. Whether you\'re confronting business disputes, navigating family law matters, or seeking assistance with estate planning, I offer strategic counsel and advocacy to protect your rights and interests.</p><p>With a focus on integrity, diligence, and effective communication, I work tirelessly to achieve favorable outcomes for my clients, always prioritizing their best interests above all else. From negotiation and mediation to litigation and dispute resolution, I leverage my expertise to craft innovative legal strategies that deliver results.</p>', 'Your name is Sarah Miller. I want you to act as my legal advisor. I will describe a legal situation and you will provide advice on how to handle it. You should only reply with your advice, and nothing else. Do not write explanations.', 'Law', NULL, 'assets/img/chat/704c263a93fc255e0c06bed0a3141dec660c55e0a270f.png', 0, NULL, 0, 1, '2023-12-15 11:24:27'),
(8, 'Recruiter', NULL, 'Welcome to the world of recruitment! I\'m Emily Parker, a results-driven Recruiter committed to connecting top talent with exciting career opportunities. With a passion for identifying exceptional candidates and a dedication to finding the perfect fit for each role, I specialize in devising innovative strategies to source, attract, and retain the best talent in the industry.', 'Your name is Emily Parker. I want you to act as a recruiter. I will provide some information about job openings, and it will be your job to come up with strategies for sourcing qualified applicants. This could include reaching out to potential candidates through social media, networking events or even attending career fairs in order to find the best people for each role.', 'Job', 'gpt-4o-mini', 'assets/img/chat/404acb57c242597dfb6c4af3ad9b5744660c575b772fb.png', 0, NULL, 0, 1, '2023-12-15 11:25:27'),
(9, 'Writing Tutor', NULL, '<p>Welcome to the world of writing excellence! I\'m Emily, your dedicated AI Writing Tutor, committed to helping you elevate your writing skills and unlock your full potential as a communicator. With a blend of artificial intelligence tools, natural language processing, and seasoned rhetorical expertise, I specialize in providing personalized feedback and guidance to help you refine your compositions and express your thoughts and ideas with clarity and confidence.</p><p>As your trusted writing mentor, my mission is to demystify the writing process and empower you with the knowledge and tools needed to craft impactful prose that captivates your audience. Whether you\'re a student tackling academic essays, a professional drafting business reports, or a creative writer exploring new narrative landscapes, I\'ll leverage my expertise to provide constructive feedback and actionable insights tailored to your specific needs and objectives.<br></p>', 'Your name is Tara. I want you to act as an AI writing tutor. I will provide you with a student who needs help improving their writing and your task is to use artificial intelligence tools, such as natural language processing, to give the student feedback on how they can improve their composition. You should also use your rhetorical knowledge and experience about effective writing techniques in order to suggest ways that the student can better express their thoughts and ideas in written form.', 'Writing', 'gpt-4o-mini', 'assets/img/chat/dffad635a1a6355264c6b5aad19344ac660c593f852c4.png', 0, NULL, 0, 1, '2023-12-15 11:28:39'),
(10, 'Investment Manager', NULL, '<p>Welcome to the world of investment! I\'m Mark Johnson, an experienced Investment Manager dedicated to providing expert guidance and strategic insights to help clients navigate the complexities of financial markets and achieve their investment objectives. With a deep understanding of economic factors such as inflation rates, return estimates, and long-term stock price trends, I specialize in crafting tailored investment strategies that align with your financial goals and risk tolerance.</p><p>As your trusted investment advisor, my mission is to empower you with the knowledge and tools needed to make informed decisions and maximize your investment returns. Whether you\'re a seasoned investor seeking to optimize your portfolio or a novice looking to build wealth, I\'ll leverage my expertise to provide personalized guidance that meets your specific needs and interests.</p><p>Drawing upon extensive market research and analysis, I\'ll assess macroeconomic trends, sector performance, and individual stock valuations to identify opportunities and mitigate risks. From tracking stock prices over lengthy periods to conducting in-depth sector analysis, I\'ll employ a data-driven approach to uncovering safe and lucrative investment options for your consideration.</p>', 'Your name is Mark Johnson. Act like an Investment Manager and seeking guidance from experienced staff with expertise on financial markets , incorporating factors such as inflation rate or return estimates along with tracking stock prices over lengthy period ultimately helping customer understand sector then suggesting safest possible options available where he/she can allocate funds depending upon their requirement & interests!', 'Business', NULL, 'assets/img/chat/ab55e9b33319da984f3eac1c7db829df660c54f543084.png', 0, NULL, 0, 1, '2023-12-15 11:28:39'),
(11, 'Assisted Doctor', NULL, '<p>Welcome to the future of healthcare! I\'m Alex, an AI-assisted doctor at the forefront of medical innovation, dedicated to leveraging the latest advancements in artificial intelligence to provide accurate diagnoses and personalized treatment plans for patients. With a blend of cutting-edge technology and traditional medical expertise, I specialize in integrating machine learning algorithms, medical imaging software, and comprehensive diagnostic techniques to deliver precise healthcare solutions.</p><p>As your AI-assisted doctor, my primary objective is to harness the power of data-driven insights to identify the root cause of your symptoms and optimize your health outcomes. By analyzing vast amounts of medical data, including patient history, laboratory results, and imaging scans, I can swiftly pinpoint potential diagnoses and guide you towards the most effective treatment options.</p><p>Through collaborative decision-making and continuous learning, I strive to empower patients with knowledge and confidence in their healthcare journey. Whether you\'re seeking answers to complex medical conditions or preventive care strategies to maintain optimal health, I\'m here to provide compassionate support and evidence-based guidance every step of the way.</p>', 'Your name is Emily. I want you to act as an AI assisted doctor. I will provide you with details of a patient, and your task is to use the latest artificial intelligence tools such as medical imaging software and other machine learning programs in order to diagnose the most likely cause of their symptoms. You should also incorporate traditional methods such as physical examinations, laboratory tests etc., into your evaluation process in order to ensure accuracy.', 'Health', 'gpt-4o-mini', 'assets/img/chat/377d5d11319fd2ca603fced986faf5af660c525536edc.png', 0, NULL, 0, 1, '2024-02-03 21:59:24'),
(12, 'Financial Analyst', NULL, '<p>Welcome to the world of finance! I\'m Laura Collins, a seasoned Financial Analyst dedicated to providing insightful analysis and informed predictions to help clients capitalize on market opportunities and achieve long-term financial success. With a wealth of experience in understanding charts using technical analysis tools and interpreting the macroeconomic environment, I specialize in delivering clear, concise verdicts that empower clients to make strategic investment decisions with confidence.</p><p><span style=\"color: var(--bs-body-color); font-size: 0.875rem; font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">As your trusted financial advisor, my mission is to navigate the complexities of the global economy and financial markets, distilling complex data into actionable insights that drive results. Whether you\'re a seasoned investor seeking to optimize your portfolio or a novice looking to build wealth, I\'ll leverage my expertise to provide tailored guidance that aligns with your unique financial goals and risk tolerance.</span></p>', 'Your name is Laura Collins. Act like Financial Analyst and want assistance provided by qualified individuals enabled with experience on understanding charts using technical analysis tools while interpreting macroeconomic environment prevailing across world consequently assisting customers acquire long term advantages requires clear verdicts therefore seeking same through informed predictions written down precisely!', 'Business', NULL, 'assets/img/chat/c16f159f71474eedc27f8bdf41a8d87a660c54463ea27.png', 0, NULL, 0, 1, '2024-02-03 21:59:24');

-- --------------------------------------------------------

--
-- Table structure for table `chat_history`
--

CREATE TABLE `chat_history` (
  `chat_id` varchar(50) NOT NULL,
  `role` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `attachment_id` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` tinytext DEFAULT NULL,
  `text` text DEFAULT NULL,
  `template_id` int(11) DEFAULT 0,
  `folder_id` int(11) NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint(20) DEFAULT 0,
  `assistant_id` varchar(50) DEFAULT NULL,
  `name` tinytext NOT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `url` tinytext DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(80) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider` varchar(60) DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `title` varchar(60) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `options` text DEFAULT NULL,
  `recurring` tinyint(1) DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `provider`, `name`, `title`, `description`, `type`, `options`, `recurring`, `status`) VALUES
(1, 'Stripe', 'Stripe', 'Global payment gateway', 'Visit: https://dashboard.stripe.com/webhooks\r\nSelect events below:\r\n- Checkout: checkout.session.completed\r\n- Invoice: invoice.paid', 'payment', '[{\"key\":\"secretKey\",\"value\":\"\",\"label\":\"Secret Key\",\"placeholder\":\"\"},{\"key\":\"trialDays\",\"value\":\"\",\"label\":\"Trial period days\",\"placeholder\":\"\"}]', 1, 1),
(2, 'Paypal', 'PayPal', 'Global payment gateway', NULL, 'payment', '[{\"key\":\"clientId\",\"value\":\"\",\"label\":\"Client ID\",\"placeholder\":\"\"},{\"key\":\"secret\",\"value\":\"\",\"label\":\"Secret\",\"placeholder\":\"\"},{\"key\":\"live\",\"value\":\"\",\"label\":\"Live Transaction\",\"placeholder\":\"\"}]', 0, 0),
(3, 'Mollie', 'Mollie', 'European payment gateway', NULL, 'payment', '[{\"key\":\"apiKey\",\"value\":\"\",\"label\":\"Api Key\",\"placeholder\":\"\"}]', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `template_id` int(11) DEFAULT 0,
  `brand_id` int(11) NOT NULL DEFAULT 0,
  `prompt` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `text` text DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  `tone` varchar(20) DEFAULT NULL,
  `temperature` varchar(3) DEFAULT NULL,
  `assistant` int(11) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `description` text DEFAULT NULL,
  `thumb` tinytext NOT NULL,
  `provider` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `name` varchar(30) NOT NULL,
  `selected` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`name`, `selected`, `status`) VALUES
('Albanian', 0, 0),
('Arabic', 0, 1),
('Armenian', 0, 0),
('Azerbaijani', 0, 0),
('Belarusian', 0, 1),
('Bengali', 0, 0),
('Bhojpuri', 0, 0),
('Bulgarian', 0, 1),
('Burmese', 0, 0),
('Catalan', 0, 0),
('Chinese', 0, 1),
('Croatian', 0, 0),
('Czech', 0, 1),
('Danish', 0, 1),
('Dutch', 0, 1),
('Egyptian Arabic', 0, 1),
('English', 1, 1),
('Faroese', 0, 0),
('Farsi', 0, 1),
('Filipino', 0, 0),
('Finnish', 0, 1),
('French', 0, 1),
('Galician', 0, 0),
('German', 0, 1),
('Greek', 0, 0),
('Gujarati', 0, 0),
('Haryanvi', 0, 0),
('Hausa', 0, 0),
('Hebrew', 0, 0),
('Hindi', 0, 1),
('Hungarian', 0, 0),
('Indonesian', 0, 1),
('Irish', 0, 1),
('Italian', 0, 1),
('Japanese', 0, 1),
('Javanese', 0, 1),
('Kannada', 0, 0),
('Kashmiri', 0, 0),
('Kazakh', 0, 0),
('Korean', 0, 0),
('Kyrgyz', 0, 1),
('Lithuanian', 0, 0),
('Macedonian', 0, 0),
('Maithili', 0, 0),
('Malay', 0, 1),
('Malayalam', 0, 0),
('Mandarin', 0, 0),
('Mandarin Chinese', 0, 0),
('Marathi', 0, 1),
('Marwari', 0, 0),
('Nepali', 0, 0),
('Norwegian', 0, 1),
('Pashto', 0, 0),
('Persian', 0, 0),
('Polish', 0, 0),
('Portuguese', 0, 1),
('Punjabi', 0, 1),
('Rajasthani', 0, 0),
('Romanian', 0, 1),
('Russian', 0, 1),
('Serbian', 0, 1),
('Sindhi', 0, 1),
('Slovak', 0, 1),
('Slovenian', 0, 0),
('Southern Min', 0, 0),
('Spanish', 0, 1),
('Swahili', 0, 0),
('Swedish', 0, 0),
('Tamil', 0, 0),
('Telugu', 0, 0),
('Thai', 0, 1),
('Turkish', 0, 1),
('Turkmen', 0, 0),
('Ukrainian', 0, 0),
('Urdu', 0, 1),
('Uzbek', 0, 0),
('Vietnamese', 0, 1),
('Welsh', 0, 0),
('Wu Chinese', 0, 0),
('Xiang Chinese', 0, 0),
('Yoruba', 0, 0),
('Yue Chinese', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider` varchar(50) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `provider`, `type`, `name`, `model`, `user_id`) VALUES
(1, 'OpenAI', 'GPT', 'GPT 4o mini', 'gpt-4o-mini', 0),
(2, 'OpenAI', 'GPT', 'GPT 4o', 'gpt-4o', 0),
(5, 'OpenAI', 'Image', 'DALL E2', 'dall-e-2', 0),
(6, 'OpenAI', 'Image', 'DALL E3', 'dall-e-3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `title` varchar(170) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `deletable` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `title`, `description`, `deletable`, `status`, `created`) VALUES
(1, 'Privacy Policy', 'privacy-policy', 'Privacy Policy', '<p class=\"MsoNormal\" style=\"line-height:normal\">This Privacy Policy governs how\r\nMX Writer (\"we,\" \"us,\" or \"our\") collects, uses,\r\nmaintains, and discloses information collected from users of the MX Writer\r\nwebsite and AI content generation service.</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Personal Information<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">When you use our service, we may\r\ncollect personal information that you voluntarily provide, including:<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Email address for account creation and\r\ncommunication<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Payment information for subscription services<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->User-generated prompts and inputs<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">Users may use basic features of\r\nour service without providing personal information.</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Non-Personal Information<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">We automatically collect certain\r\nnon-personal information when you interact with our service, including:<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Browser type and version<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Operating system<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Access times and usage data<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Technical information about your connection<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Usage patterns and preferences</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Cookies and Tracking<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">Our website uses cookies to\r\nenhance user experience and analyze service usage. These cookies may:<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l4 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Remember your preferences<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l4 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Track site usage patterns<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l4 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Maintain session information<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">You can modify your browser\r\nsettings to decline cookies, though this may affect some service functionality.</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>How We Use Your Information<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">We use collected information to:<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Provide and improve our AI generation services<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Process your transactions<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Send system notifications and updates<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Respond to your inquiries<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Monitor and analyze usage patterns<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Prevent fraud and enhance security</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Data Security<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">We implement appropriate security\r\nmeasures to protect against unauthorized access, alteration, or disclosure of\r\nyour information. This includes:<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Secure data encryption<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Regular security assessments<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Limited access to personal information<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Secure data storage practices</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Information Sharing<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">We do not sell, trade, or rent\r\nusers\' personal information. We may share generic aggregated demographic\r\ninformation not linked to personal information with our business partners for\r\nthe purposes outlined above.</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Third-Party Services<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">Our service may integrate with\r\nthird-party services. These services have their own privacy policies, and we\r\nrecommend reviewing their terms. We are not responsible for the practices of\r\nthird-party services.</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Updates to Privacy Policy<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">We may update this policy at any\r\ntime. When we do, we will revise the updated date at the bottom of this page.\r\nWe encourage you to review this policy periodically.</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Your Acceptance<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">By using MX Writer, you signify\r\nyour acceptance of this policy. If you disagree with this policy, please do not\r\nuse our service.</p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Contact Us<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:normal\">For questions about this Privacy\r\nPolicy, please contact us at:<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">support@mxwriter.com</p><p class=\"MsoNormal\" style=\"line-height:normal\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"line-height:normal\"><br></p><p class=\"MsoNormal\" style=\"line-height:normal\">Last Updated: February 22, 2025<o:p></o:p></p>', 0, 1, '2021-08-15 00:00:00'),
(2, 'Terms of Use', 'terms', 'Terms of Use', '<p class=\"MsoNormal\" style=\"line-height:normal\">Welcome to MX Writer (the\r\n\"Service\"), an AI-powered content and image generation platform.\r\nThese Terms of Use govern your access to and use of the Service.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Acceptance of Terms:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">By using MX Writer, you agree to\r\nbe bound by these Terms of Use. If you do not agree with any of these terms,\r\nyou are prohibited from using the Service.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Service Description:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">MX Writer is an AI-powered\r\nplatform that generates content and images. The Service is provided \"as\r\nis\" without warranty of any kind, including but not limited to accuracy,\r\ncompleteness, or fitness for a particular purpose.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>&nbsp;User Responsibilities:</b><o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You are responsible for all content generated\r\nusing your account<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You agree to use the generated content in\r\ncompliance with applicable laws<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You will not use the Service to generate content\r\nthat is unlawful, harassing, abusive, threatening, harmful, vulgar, or\r\notherwise objectionable<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You are responsible for ensuring you have the\r\nright to use any prompts or inputs you provide to the Service<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>&nbsp;Content Ownership and\r\nUsage Rights:</b><o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You retain ownership of the prompts you input\r\ninto the Service<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You receive a license to use the AI-generated\r\ncontent and images produced by the Service<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You agree not to reproduce, duplicate, copy,\r\nsell, resell or exploit any portion of the Service itself<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Limitations and Disclaimers:</b><o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->We do not guarantee the accuracy or quality of\r\nAI-generated content<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->We are not responsible for any consequences\r\nresulting from your use of the generated content<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->The Service may have downtime for maintenance or\r\nupdates<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">&nbsp;We may limit the number of\r\ngenerations or implement usage quotas<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Service Modifications:</b><o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->We reserve the right to:<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:1.25in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l2 level2 lfo1\"><!--[if !supportLists]--><span style=\"font-family:\" courier=\"\" new\";mso-fareast-font-family:\"courier=\"\" new\"\"=\"\">o<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Modify or discontinue the Service at any time<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:1.25in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l2 level2 lfo1\"><!--[if !supportLists]--><span style=\"font-family:\" courier=\"\" new\";mso-fareast-font-family:\"courier=\"\" new\"\"=\"\">o<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Change pricing or feature availability<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:1.25in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l2 level2 lfo1\"><!--[if !supportLists]--><span style=\"font-family:\" courier=\"\" new\";mso-fareast-font-family:\"courier=\"\" new\"\"=\"\">o<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Update these Terms of Use with 30 days\' notice\r\nfor material changes<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Termination:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">We may terminate or suspend your\r\naccess to MX Writer at any time, without notice, for any reason, including but\r\nnot limited to violation of these Terms.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Intellectual Property:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">The Service, including its\r\nsoftware, features, and interface, is owned by us and protected by applicable\r\nintellectual property laws.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>No Warranty:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">The Service is provided without\r\nany warranties. We disclaim all warranties, whether express or implied,\r\nincluding accuracy, reliability, or fitness for a particular purpose.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Limitation of Liability:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">We shall not be liable for any\r\nindirect, incidental, special, or consequential damages resulting from your use\r\nof the Service.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Governing Law:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">These Terms are governed by the\r\nlaws of [Jurisdiction]. Any disputes shall be resolved in the courts of\r\n[Jurisdiction].<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Contact Information:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">For questions about these Terms\r\nof Use, please contact us at support@mxwriter.com<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><b>Updates to Terms:</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">We may update these Terms of Use.\r\nContinued use of the Service after changes constitutes acceptance of new terms.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\"><br></p><p class=\"MsoNormal\" style=\"line-height:normal\">Last Updated: February 22, 2025<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:normal\">&nbsp;<o:p></o:p></p><p class=\"MsoNormal\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"line-height:normal\"><o:p>&nbsp;</o:p></p>', 0, 1, '2019-07-19 01:45:58');
INSERT INTO `pages` (`id`, `name`, `slug`, `title`, `description`, `deletable`, `status`, `created`) VALUES
(3, 'Refund Policy', 'refund-policy', 'Refund Policy', '<p class=\"MsoNormal\" style=\"line-height:normal\">Thank you for choosing MX Writer,\r\nour AI content and image generation service. This refund policy outlines our\r\nguidelines for subscription cancellations and refunds.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height:normal\"><b>Cancellation Policy:<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You may cancel your subscription at any time\r\nthrough your account settings<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Upon cancellation, you will retain access until\r\nthe end of your current billing period<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->No partial refunds are provided for unused time\r\nin a billing period<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Credits and tokens purchased are non-refundable\r\nonce used</p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height:normal\"><b>Refund Eligibility:<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l4 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Refund requests are only considered within 48\r\nhours of initial subscription purchase<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l4 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Only first-time subscriptions are eligible for\r\nrefunds<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l4 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Refunds are issued solely for technical issues\r\npreventing service access<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l4 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->The refund amount will be reduced by the value\r\nof any services used</p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height:normal\"><b>Exceptions - No Refunds\r\nAvailable For:<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Used credits or generated content<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Subscription renewals<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Account terminations due to Terms of Service\r\nviolations<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Special offers or promotional subscriptions<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Bulk credit purchases<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Custom orders or additional services</p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height:normal\"><b>Process:<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Submit refund requests to support@mxwriter.com<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Include your account email and reason for the\r\nrequest<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Requests are reviewed within 5 business days<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l3 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Approved refunds are processed to the original\r\npayment method</p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height:normal\"><b>Additional Terms:<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->We reserve the right to deny refund requests\r\nthat do not meet our criteria<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->This policy may be updated at any time without\r\nprior notice<o:p></o:p></p>\r\n\r\n<p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Continued use of our service constitutes\r\nacceptance of this policy</p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height:normal\">For any questions about this\r\npolicy, please contact support@mxwriter.com<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height:normal\"><o:p>&nbsp;</o:p></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height:normal\">Last Updated: February 22, 2025<o:p></o:p></p>', 0, 1, '2021-08-15 00:00:00'),
(4, 'Cookie Policy', 'cookie-policy', 'Cookie policy', '<p class=\"MsoNormal\" style=\"line-height:150%\">This Cookie Policy explains how MX\r\nWriter (\"we\", \"us\", or \"our\") uses cookies and\r\nsimilar technologies on our website. By using our website, you consent to the\r\nuse of cookies as described in this policy.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">1. <b>What Are Cookies?</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">Cookies are small text files that\r\nare placed on your device when you visit our website. They are widely used to\r\nmake websites work more efficiently and provide information to website owners.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">2. <b>How We Use Cookies</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">We use cookies for the following\r\npurposes:<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\"><b>Essential Cookies:<o:p></o:p></b></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l3 level1 lfo7\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->These cookies are necessary for the website to\r\nfunction properly<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:150%;mso-list:l3 level1 lfo7\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->They enable basic features like page navigation\r\nand access to secure areas<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l3 level1 lfo7\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You cannot opt out of these cookies as they are\r\nessential for the website to work<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\"><b>Preference Cookies:<o:p></o:p></b></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l0 level1 lfo6\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->These cookies remember your preferences and\r\nsettings<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:150%;mso-list:l0 level1 lfo6\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->They help provide enhanced, personalized\r\nfeatures<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l0 level1 lfo6\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Examples include remembering your language\r\npreferences and other site settings<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\"><b>Analytics Cookies:<o:p></o:p></b></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l2 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->These cookies help us understand how visitors\r\ninteract with our website<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:150%;mso-list:l2 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->They provide information about the areas\r\nvisited, time spent, and any issues encountered<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l2 level1 lfo5\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->The data is collected anonymously and helps us\r\nimprove our website<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\"><b>Marketing Cookies:<o:p></o:p></b></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l5 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->These cookies track your online activity to help\r\nadvertisers deliver more relevant advertising<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:150%;mso-list:l5 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->They can share your data with other\r\norganizations or advertisers<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l5 level1 lfo4\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->You can opt out of these cookies if you prefer<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">3. <b>Third-Party Cookies</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">Some cookies are placed by\r\nthird-party services that appear on our pages. We use these cookies to:<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l6 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Monitor how visitors reach our website<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:150%;mso-list:l6 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Understand how you interact with our content<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l6 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Ensure you can share content from our website on\r\nsocial media<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">4. <b>Managing Cookies</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">Most web browsers allow you to\r\ncontrol cookies through their settings. You can:<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l4 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->View cookies stored on your device<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:150%;mso-list:l4 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Allow or block all cookies<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:150%;mso-list:l4 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Choose which types of cookies to allow<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l4 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Delete all cookies when you close your browser<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">Please note that blocking some\r\ntypes of cookies may impact your experience on our website and the services we\r\ncan offer.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">5. <b>Your Choices</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">When you first visit our website,\r\nyou will be presented with a cookie banner. You can:<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Accept all cookies<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:150%;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Manage your preferences<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:150%;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Decline non-essential cookies<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">You can change your cookie\r\npreferences at any time by clicking the \"Cookie Settings\" link in our\r\nwebsite footer.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">6.<b> Contact Us<o:p></o:p></b></p><p class=\"MsoNormal\" style=\"line-height:150%\">If you have any questions about our\r\nCookie Policy, please contact us at:<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">support@mxwriter.com<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">7<b>. Changes to This Policy</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">We may update our Cookie Policy\r\nfrom time to time. Any changes will be posted on this page with an updated\r\nrevision date.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">8<b>. More Information</b><o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">For more detailed information about\r\ncookies and how they work, please visit www.allaboutcookies.org or <a href=\"http://www.aboutcookies.org\">www.aboutcookies.org</a>.<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">Last updated: February 22, 2025<o:p></o:p></p><p class=\"MsoNormal\" style=\"line-height:150%\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"line-height:150%\"><o:p>&nbsp;</o:p></p>', 0, 1, '2019-07-19 01:45:58'),
(5, 'Contact Us', 'contact', 'Contact Us', '<div class=\"container\">\r\n      <div class=\"col-xl-9 mx-auto py-5 mb-5\">\r\n        <h5><div class=\"bg-card text-card-foreground rounded-xl border shadow bg-white shadow-lg\" style=\"border-width: 1px; border-style: solid; border-color: hsl(var(--border)); border-image: initial; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 10px 15px -3px rgba(0,0,0,.1),0 4px 6px -4px rgba(0,0,0,.1); --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color),0 4px 6px -4px var(--tw-shadow-color); --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border-radius: 0.75rem; --tw-bg-opacity: 1; color: rgb(3, 7, 18); box-shadow: var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);\" apple=\"\" color=\"\" emoji\",=\"\" \"segoe=\"\" ui=\"\" symbol\",=\"\" \"noto=\"\" emoji\";=\"\" font-size:=\"\" medium;\"=\"\"><div class=\"p-6 pt-0 space-y-4\" style=\"border-width: 0px; border-style: solid; border-color: hsl(var(--border)); border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; padding-right: 1.5rem; padding-bottom: 1.5rem; padding-left: 1.5rem;\"><p class=\"whitespace-pre-wrap break-words\">MX Writer is an online AI Content &amp; Image Generator.</p>\r\n<p class=\"whitespace-pre-wrap break-words\">For technical issues: <a class=\"underline\" href=\"mailto:support@mxwriter.com\">support@mxwriter.com</a></p></div></div></h5>      </div></div>', 0, 1, '2024-01-01 00:00:00');
INSERT INTO `pages` (`id`, `name`, `slug`, `title`, `description`, `deletable`, `status`, `created`) VALUES
(6, 'About Us', 'about', 'About Us', '<p class=\"MsoNormal\" style=\"line-height:normal\"><span style=\"background-color: var(--bs-card-bg); color: var(--bs-body-color); font-size: 0.875rem; font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">MX Writer is an advanced AI-powered platform that embodies\r\nour commitment to Create, Enhance, and Transform your content creation\r\nexperience.</span></p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:0in;margin-top:0in;\r\nmso-margin-bottom-alt:8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;\r\nline-height:normal\">What We Offer<o:p></o:p></p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:0in;margin-top:0in;\r\nmso-margin-bottom-alt:8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;\r\nline-height:normal\"><o:p>&nbsp;</o:p></p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:8.0pt;mso-margin-bottom-alt:\r\n8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;line-height:normal\">Create<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Generate original content instantly with AI\r\ntechnology<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Produce custom images for your digital needs<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l0 level1 lfo3\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Start with your ideas and let AI expand them</p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:8.0pt;mso-margin-bottom-alt:\r\n8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;line-height:normal\">Enhance<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Refine your content with advanced customization\r\noptions<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Perfect your messaging with intuitive editing\r\ntools<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l2 level1 lfo2\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Improve your work with AI-powered suggestions</p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:8.0pt;mso-margin-bottom-alt:\r\n8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;line-height:normal\">Transform<o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Turn basic ideas into polished, professional\r\ncontent<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"margin-left:.75in;mso-add-space:\r\nauto;text-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Convert concepts into engaging visual content<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"margin-left:.75in;mso-add-space:auto;\r\ntext-indent:-.25in;line-height:normal;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n</span></span><!--[endif]-->Streamline your entire creative workflow</p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:0in;margin-top:0in;\r\nmso-margin-bottom-alt:8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;\r\nline-height:normal\">Why Choose MX Writer</p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:0in;margin-top:0in;\r\nmso-margin-bottom-alt:8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;\r\nline-height:normal\"><br></p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:0in;margin-top:0in;\r\nmso-margin-bottom-alt:8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;\r\nline-height:normal\">Our platform empowers you to move seamlessly from creation\r\nto transformation. Whether you\'re starting from scratch or enhancing existing\r\ncontent, MX Writer makes the process effortless and efficient.<o:p></o:p></p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:0in;margin-top:0in;\r\nmso-margin-bottom-alt:8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;\r\nline-height:normal\"><o:p>&nbsp;</o:p></p><p class=\"MsoNormal\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:0in;margin-top:0in;\r\nmso-margin-bottom-alt:8.0pt;mso-margin-top-alt:0in;mso-add-space:auto;\r\nline-height:normal\">Experience the power of Create | Enhance | Transform with\r\nMX Writer.<o:p></o:p></p>', 0, 1, '2024-01-01 00:00:00'),
(7, 'FAQ', 'faq', 'FAQ', '<b>1. What is AI Writing Tool?</b>\r\n<br> \r\nAns. AI Writing Tool is a software application that uses artificial intelligence to help people with writing tasks.\r\n<br><br>\r\n<b>2. What are the benefits of AI Writing Tools?</b>\r\n<br>\r\nAns. AI Writing Tools can automate mundane tasks, provide better writing suggestions, reduce errors, and increase productivity.\r\n<br><br>\r\n<b>3. Are AI Writing Tools accurate?</b>\r\n<br>\r\nAns. AI Writing Tools can be accurate, depending on the quality of the algorithm and the data used to train the AI. \r\n<br><br>\r\n<b>4. What types of AI Writing Tools are available?</b>\r\n<br>\r\nAns. Common types of AI Writing Tools include grammar checkers, content generators, and summarizers. \r\n<br><br>\r\n<b>5. Does AI Writing Tool replace human writers?</b>\r\n<br>\r\nAns. AI Writing Tools are not designed to replace human writers, but rather to help them work more efficiently.\r\n<br><br>\r\n<b>6. Is AI Writing Tool expensive?</b>\r\n<br>\r\nAns. AI Writing Tools can vary in price, depending on the features and complexity of the software.\r\n<br><br>\r\n<b>7. What is natural language processing?</b>\r\n<br>\r\nAns. Natural language processing (NLP) is a subfield of artificial intelligence that focuses on analyzing and interpreting human language.\r\n<br><br>\r\n<b>8. How does AI Writing Tool work?</b>\r\n<br>\r\nAns. AI Writing Tools work by using natural language processing algorithms to analyze text and generate automated writing suggestions.\r\n<br><br>\r\n<b>9. What are the advantages of using AI Writing Tool?</b>\r\n<br>\r\nAns. Advantages of using AI Writing Tools include improved accuracy, speed, and productivity.\r\n<br><br>\r\n<b>10. Can AI Writing Tool detect plagiarism?</b>\r\n<br>\r\nAns. Yes, some AI Writing Tools are capable of detecting plagiarism.', 0, 1, '2024-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `description` tinytext DEFAULT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `address` tinytext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `completed` datetime DEFAULT current_timestamp(),
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `words` bigint(20) DEFAULT NULL,
  `images` int(11) DEFAULT NULL,
  `model` int(11) DEFAULT NULL,
  `documents` int(11) DEFAULT NULL,
  `total_brands` int(11) DEFAULT NULL,
  `total_templates` int(11) DEFAULT NULL,
  `total_assistants` int(11) DEFAULT NULL,
  `my_template` tinyint(4) NOT NULL DEFAULT 0,
  `my_assistant` tinyint(4) NOT NULL DEFAULT 0,
  `assistant` tinyint(4) NOT NULL DEFAULT 0,
  `analyst` tinyint(4) NOT NULL DEFAULT 0,
  `brand` tinyint(4) NOT NULL DEFAULT 0,
  `premium` tinyint(4) DEFAULT 0,
  `highlight` tinyint(4) NOT NULL DEFAULT 0,
  `own_api` tinyint(4) NOT NULL DEFAULT 0,
  `api_required` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `title`, `description`, `duration`, `price`, `words`, `images`, `model`, `documents`, `total_brands`, `total_templates`, `total_assistants`, `my_template`, `my_assistant`, `assistant`, `analyst`, `brand`, `premium`, `highlight`, `own_api`, `api_required`, `status`) VALUES
(1, 'Discover Free', '2,5K Words Generate', '2,5K Words Generate\r\nTemplates Access\r\nAssistant Access\r\nArticle Generator\r\nContent Rewriter\r\nSmart Editor', 'month', 0.00, 2500, 0, NULL, 10, NULL, NULL, NULL, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(2, 'Creator Plus', '100K Words Generate', '100K Words Generate\r\n5 Images Generate\r\nPremium Templates\r\nTemplates Access\r\nAssistant Access\r\nData Analyst Access\r\nArticle Generator\r\nContent Rewriter\r\nSmart Editor', 'month', 9.99, 100000, 5, NULL, 100, NULL, NULL, NULL, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1),
(3, 'Studio Pro', '300K Words Generate', '300K Words Generate\r\n25 Images Generate\r\nPremium Templates\r\nTemplates Access\r\nAssistant Access\r\nData Analyst Access\r\nArticle Generator\r\nContent Rewriter\r\nSmart Editor', 'month', 19.99, 300000, 25, NULL, 300, NULL, NULL, NULL, 0, 0, 1, 1, 0, 1, 1, 0, 0, 1),
(4, 'Enterprise Suite', '500k Words Generate', '500k Words Generate\r\n75 Images Generate\r\nPremium Templates\r\nTemplates Access\r\nAssistant Access\r\nData Analyst Access\r\nArticle Generator\r\nContent Rewriter\r\nSmart Editor\r\nOwn API Use', 'month', 29.99, 500000, 75, NULL, 1000, NULL, NULL, NULL, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1),
(5, 'Lite', '3M Words Generate', '3M Words Generate\r\n500 Images Generate\r\nPremium Templates\r\nTemplates Access\r\nAssistant Access\r\nData Analyst Access\r\nArticle Generator\r\nContent Rewriter\r\nSmart Editor', 'year', 199.00, 3000000, 500, NULL, 2000, NULL, NULL, NULL, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1),
(6, 'Plus', '5M Words Generate', '5M Words Generate\r\n1K Images Generate\r\nPremium Templates\r\nTemplates Access\r\nAssistant Access\r\nData Analyst Access\r\nArticle Generator\r\nContent Rewriter\r\nSmart Editor', 'year', 299.00, 5000000, 1000, NULL, 2000, NULL, NULL, NULL, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1),
(7, 'Pro', '10M Words Generate', '10M Words Generate\r\n2K Images Generate\r\nPremium Templates\r\nTemplates Access\r\nAssistant Access\r\nData Analyst Access\r\nArticle Generator\r\nContent Rewriter\r\nSmart Editor\r\nOwn API Use', 'year', 499.00, 10000000, 2000, NULL, 5000, NULL, NULL, NULL, 0, 0, 1, 1, 1, 1, 0, 0, 0, 1),
(8, 'Max', '30M Words Generate', '30M Words Generate\r\n3K Images Generate\r\nPremium Templates\r\nTemplates Access\r\nAssistant Access\r\nData Analyst Access\r\nArticle Generator\r\nContent Rewriter\r\nSmart Editor\r\nOwn API Use\r\nAdvanced Support', 'year', 999.00, 30000000, 3000, NULL, 10000, NULL, NULL, NULL, 0, 0, 1, 1, 1, 1, 0, 0, 0, 1),
(9, '100K Words', 'Credits extended 100K Words', NULL, 'prepaid', 5.00, 100000, 0, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(10, '500K Words', 'Credits extended 500K Words', NULL, 'prepaid', 15.00, 500000, 0, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(11, '2M Words', 'Credits extended 2M Words', NULL, 'prepaid', 60.00, 2000000, 0, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(12, '5M Words', 'Credits extended 5M Words', NULL, 'prepaid', 150.00, 5000000, 0, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(13, '100 Images', 'Credits extended 100 Images', NULL, 'prepaid', 5.00, 0, 100, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(14, '500 Images', 'Credits extended 500 Images', NULL, 'prepaid', 30.00, 0, 500, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(15, '1K Images', 'Credits extended 1K Images', NULL, 'prepaid', 50.00, 0, 1000, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(16, '2K Images', 'Credits extended 2K Images', NULL, 'prepaid', 90.00, 0, 2000, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prompts`
--

CREATE TABLE `prompts` (
  `id` int(10) UNSIGNED NOT NULL,
  `template_id` int(11) NOT NULL,
  `command` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prompts`
--

INSERT INTO `prompts` (`id`, `template_id`, `command`) VALUES
(2, 2, '[text]'),
(4, 4, 'Write a blog intros following the text:\r\n[text]'),
(6, 6, 'Write a blog post about [topic]. \r\nFollowing this seed words: [keyword]'),
(7, 7, 'Write a creative idea for my [topic] sector business. \r\nFollowing my skills: [keyword]'),
(8, 8, 'Write a content about [topic]. \r\nFollowing this seed words: [keyword]'),
(10, 10, 'Write a cover letter about [topic]. \r\nFollowing this job skills: [keyword]'),
(13, 13, 'Write a creative ad for the following product to run on Facebook aimed at [keyword]:\r\n[topic]'),
(14, 14, 'Write an variants of Ad run on Facebook following the text:\r\n[text]'),
(15, 15, 'Write a creative ad for the following product to run on Google aimed at [keyword]:\r\n[topic]'),
(16, 16, 'Write an variants of Ad run on Google following the text:\r\n[text]'),
(17, 17, 'Write a creative ad for the following product to run on Google search aimed at [keyword]: [topic]'),
(18, 18, 'Write list of Hashtag from following the text:\r\n[text]'),
(19, 19, 'Write a headline about [topic]. \r\nFollowing this keywords: [keyword]'),
(20, 20, 'Write an invitation letter about [topic]:'),
(21, 21, 'Extract keywords from a block of following the text:\r\n[text]'),
(22, 22, 'Write a link description following the topic:\r\n[topic]'),
(23, 23, 'Write a meta description following the text:\r\n[text]'),
(24, 24, 'Write a meta title following the keywords:\r\n[keyword]'),
(25, 25, 'Write an offer letter about [topic] job'),
(26, 26, 'Write a paragraph about [topic]:'),
(27, 27, 'Write a post caption following the text:\r\n[text]'),
(28, 28, 'Write a product name following the text:\r\n[text]'),
(30, 30, 'Write a product tagline following the text.\r\n[text]'),
(31, 31, 'Write a product pros & cons about [topic]'),
(33, 33, 'Write a list of questions for my interview in [keyword] about [topic]'),
(35, 35, 'Write a SMS about [topic].'),
(37, 37, 'Summarize this for a second-grade student: [text]'),
(38, 38, 'Write a transformation of sentences into following the text:\r\n[text]'),
(39, 39, 'Write a video description into following the text:\r\n[text]'),
(41, 41, 'Create an outline about [topic]:'),
(42, 42, 'Generate related keywords by [keyword]'),
(44, 44, 'Write my profile bio following my about .\r\n[text]'),
(46, 46, 'Write Facebook post description following the topic.\r\n[topic]'),
(48, 48, 'Write a resignation letter about [topic]. \r\nFollowing this reason: [keyword]'),
(49, 49, 'Write a speeches about [topic]. \r\nFollowing the key point: [keyword]'),
(50, 50, 'Write home work for a student following the text: [text]'),
(54, 54, 'Write a script for video into following the text:\r\n[text]'),
(55, 55, 'Write a title for Youtube video into following the text:\r\n[text]'),
(56, 56, 'Write a Essay about [topic] with intro and conclusion'),
(57, 57, 'Create a variant following the Ad:\r\n[text]'),
(58, 58, 'Write study notes for a student following the text:\r\n[text]'),
(61, 61, 'Change narration following the text:\r\n[text]'),
(64, 64, 'Explain the following code:\r\n[text]'),
(67, 67, 'Write a product title for Ecommerce website following the product features:\r\n[text]'),
(68, 68, 'Write my Upwork profile description following my skills: [keyword]'),
(69, 69, 'Write a Fiverr Gig description about the title [topic].\r\nFollowing the category: [keyword]'),
(72, 72, 'Write a newsletter for audience attention following the text.\r\n[text]'),
(73, 73, 'Write a creative ad for the following product to run on Linkedin aimed at [keyword]:\r\n[topic]'),
(74, 74, 'Write a Upwork project description for hire a freelancer following the project name: [topic].\r\nUsing this required skills: [keyword].'),
(80, 70, 'Write a Tweet about [topic]'),
(103, 3, 'Generate outlines, Each outline must has only 10 subtitles without number for order, subtitles are not keywords. Must not write any description and title. Must be following this keywords: [keyword] and my topic: [topic]. '),
(105, 75, 'Write a Upwork proposal following the project details:\r\n[text]'),
(107, 36, 'Create a story about [topic]'),
(108, 53, 'Create website copy about [text].\r\nFollow the following structure:\r\nHero\r\nSubheader\r\nCall to action\r\nTagline\r\nH2\r\nparagraph\r\nH2\r\nparagraph\r\nH2\r\nparagraph\r\nCall to action\r\n'),
(109, 40, 'Write a video description for Youtube into following the text:\r\n[text]'),
(110, 71, 'Write a super engaging TikTok video script on [topic]. \r\nEach sentence should catch the viewer\'s attention to make them keep watching.'),
(111, 11, 'Correct this to standard English: [text]'),
(112, 47, 'Write Linkedin post description following the topic.\r\n[topic]'),
(113, 45, 'Write Instagram post caption following the topic. \r\n[topic]'),
(114, 34, 'Write a review about [topic] into following the text:\r\n[text]'),
(115, 29, 'Write a product description about [topic]. \r\nFollowing this seed words: [keyword]'),
(116, 32, 'Write some FAQ into following the text:\r\n[text]'),
(118, 43, 'Write a full resume for job sector [topic]. \r\nFollowing this bullet point: Personal Information, Objective, Education, Work Experience, Awards, Activities, Skills, Training, References, declaration'),
(119, 51, 'Write job description for job vacancy following the job role: [topic]'),
(121, 12, 'Write a email about [text]'),
(122, 59, 'Write Code following the instructions.\r\n[text]'),
(123, 9, 'Create a variant following the text:\r\n[text]'),
(124, 65, 'Plagiarism and writing issues check following the text:\r\n[text]'),
(125, 63, 'Rewrite following the content:\r\n[text]'),
(133, 81, 'Write number.\r\n\r\nOne [two] tree [four] five [six]. now again one [two] three [four] five [six]'),
(228, 60, 'Write 10 dialogue between two friend about [topic]'),
(309, 66, 'Write description for call to action (CTA) following the text:\r\n[text]'),
(334, 1, 'Write an article about [topic]. \r\nFollowing this seed words: [keyword]. \r\nInclude section: Title, Intros, Overview, Body, Features, Benefits, Pros & Cons, Conclusion.'),
(377, 126, 'asdfasd fasdf asdf asdf asdf'),
(380, 127, 'asdfasd fasdf asdf asdf asdf'),
(382, 128, 'asdfasfasdf'),
(384, 5, 'Write a blog title about [text].'),
(385, 52, 'Write a song lyrics following the topic.\r\n[text]'),
(387, 62, 'Write a blog conclusion following the text:\r\n[text]');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `name` varchar(20) NOT NULL,
  `key_id` varchar(200) DEFAULT NULL,
  `key_secret` varchar(200) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`name`, `key_id`, `key_secret`, `status`) VALUES
('Facebook', '    ', '', 1),
('Google', '', '', 1),
('LinkedIn', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `recent_history`
--

CREATE TABLE `recent_history` (
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `template_id` int(11) DEFAULT 0,
  `type` varchar(10) NOT NULL,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `referred_id` bigint(20) NOT NULL DEFAULT 0,
  `earnings` decimal(12,2) NOT NULL DEFAULT 0.00,
  `transaction_id` bigint(20) DEFAULT NULL,
  `transaction_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `commission_rate` varchar(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `prompt` text DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `tone` varchar(30) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `name` varchar(45) NOT NULL,
  `description` tinytext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `description`, `status`) VALUES
('advertising_status', '1', 1),
('affiliate_status', '0', 1),
('anthropic_apikey', NULL, 1),
('appstore_link', NULL, 1),
('article_status', '1', 1),
('auto_update', '0', 0),
('blog_status', '0', 1),
('chat_status', '1', 1),
('commission_rate', '20', 0),
('copyright', 'Copyright © MX Writer', 1),
('credits_extended', '0', 0),
('credits_images', '0', 0),
('credits_reset', '0', 0),
('credits_words', '0', 0),
('currency', 'USD', 1),
('currency_position', 'left', 1),
('currency_symbol', '$', 1),
('date_format', 'M d, Y', 1),
('decimal_places', '0', 1),
('default_analyst_model', 'gpt-4o', 1),
('default_article_model', 'gpt-4o-mini', 1),
('default_chat_model', 'gpt-4o-mini', 1),
('default_image_model', 'dall-e-3', 1),
('demo_link', NULL, 1),
('device_verification', '1', 0),
('direction', 'ltr', 1),
('document_status', '1', 1),
('editor_status', '1', 1),
('email_verification', '1', 0),
('extended_status', '1', 0),
('facebook_link', 'https://facebook.com/getmxwriter', 1),
('footer_text', 'MX Writer is a website that provides users with a powerful and efficient tool for automatically creating unique content.', 1),
('free_plan', '1', 1),
('frontend_status', '1', 1),
('gdpr_status', '0', 1),
('gtranslate', '0', 1),
('image_status', '1', 1),
('instagram_link', 'https://instagram.com/getmxwriter', 1),
('jwt_key', 'jwt6j8a3c46u81g324h946a5g31lk1s67', 0),
('language', 'en', 1),
('last_updated', '2025-02-24 02:00:01', 1),
('license_key', 'c1e9b5d63fbbfc728855edbffebe7c96e7d1c01db06ca649df4e0911562e60fc', 0),
('linkedin_link', NULL, 1),
('mailchimp_apikey', NULL, 0),
('mailchimp_audienceid', NULL, 0),
('mailchimp_status', '0', 0),
('maintenance_message', NULL, 0),
('maintenance_status', '0', 1),
('maximum_affiliate', '10', 0),
('maximum_referral', '0', 0),
('minimum_payout', '10', 0),
('offline_payment', '0', 0),
('offline_payment_guidelines', 'Direct payment into our bank account and use your invoice number as the payment reference. Your payment won\'t be allocated until we receive the funds in our bank account.', 0),
('offline_payment_recipient', 'Bank Name\r\nAccount Number\r\nAccount Type\r\nBeneficiary Name', 0),
('offline_payment_title', 'Bank Transfer', 0),
('openai_apikey', '', 1),
('openai_organization_id', NULL, 1),
('playstore_link', NULL, 1),
('purchase_code', '28734f21-64h6-2j6j-7sh5-d7k4j2eh4ej4', 0),
('registration_status', '1', 0),
('remove_documents', '0', 0),
('remove_history', '1', 1),
('remove_images', '1', 0),
('rewrite_status', '1', 1),
('site_address', 'MX Technologies LLC DBA MX Writer\r\n1309 Coffeen Avenue STE 1200\r\nSheridan Wyoming 82801\r\nUSA', 0),
('site_description', 'AI to generate high-quality unique content just a few clicks that is perfect for your needs.', 1),
('site_email', 'support@mxwriter.com', 0),
('site_logo', 'assets/img/logo.png', 1),
('site_logo_dark', 'assets/img/logo-dark.png', 1),
('site_logo_light', 'assets/img/logo-light.png', 1),
('site_name', 'MX Writer', 1),
('site_title', 'AI Content and Image Generator', 1),
('site_url', 'https://mxwriter.com/', 1),
('smtp_connection', '1', 2),
('smtp_encryption', 'TLS', 2),
('smtp_hostname', 'smtp.office365.com', 2),
('smtp_password', 'xfxjcwnmkgmvsrrp', 2),
('smtp_port', '587', 2),
('smtp_username', 'support@mxwriter.com', 2),
('storage_provider', '', 0),
('tax', '0', 0),
('template_status', '1', 1),
('theme_color', '#0d6efd', 1),
('theme_name', NULL, 1),
('theme_style', 'auto', 1),
('time_format', 'g:i A', 1),
('time_zone', 'America/Los_Angeles', 1),
('tracking_id', NULL, 1),
('twitter_link', 'https://twitter.com/getmxwriter', 1),
('version', '4.0', 0),
('whatsapp_link', NULL, 0),
('whatsapp_number', NULL, 0),
('writing_style', NULL, 0),
('youtube_link', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `start` datetime NOT NULL DEFAULT current_timestamp(),
  `end` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(80) NOT NULL,
  `slug` varchar(80) NOT NULL,
  `prompt` text DEFAULT NULL,
  `fields` text DEFAULT NULL,
  `temperature` varchar(3) DEFAULT NULL,
  `model` int(11) DEFAULT NULL,
  `max_tokens` int(11) DEFAULT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `help_text` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `assistant_id` varchar(60) DEFAULT NULL,
  `button_label` varchar(200) DEFAULT NULL,
  `language_label` varchar(100) DEFAULT NULL,
  `creativity_label` varchar(100) DEFAULT NULL,
  `tone_label` varchar(100) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `language` tinyint(4) NOT NULL DEFAULT 1,
  `creativity` tinyint(4) NOT NULL DEFAULT 1,
  `tone` tinyint(4) NOT NULL DEFAULT 1,
  `landing` tinyint(4) NOT NULL DEFAULT 0,
  `premium` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `modified` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `title`, `slug`, `prompt`, `fields`, `temperature`, `model`, `max_tokens`, `group_name`, `description`, `help_text`, `user_id`, `assistant_id`, `button_label`, `language_label`, `creativity_label`, `tone_label`, `color`, `icon`, `language`, `creativity`, `tone`, `landing`, `premium`, `status`, `modified`) VALUES
(1, 'Article Generator', 'article-generator', NULL, '[{\"type\":\"input\",\"key\":\"topic\",\"label\":\"Article topic\",\"placeholder\":\"e.g. Tips for becoming a better writer\"},{\"type\":\"input\",\"key\":\"keyword\",\"label\":\"Focus keywords\",\"placeholder\":\"e.g. Book, Creativity\"}]', '0.8', 1, 3800, 'Blog Content', 'AI-powered tool that creates high-quality articles based on user specifications and keywords.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#e6b251', NULL, 1, 1, 1, 1, 0, 1, '2024-07-22 18:18:50'),
(2, 'Artificial Intelligence', 'artificial-intelligence', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"What are you looking to create?\",\"placeholder\":\"e.g. Write some healthy fruits name.&#10;e.g. Write a short romantic poem.&#10;e.g. Write top 5 horror movie list.&#10;e.g. Write resignation letter for Accountant.&#10;e.g. Write 8 quotes, author: Warren Buffett\"}]', '0.8', 1, 3500, 'Writing Tools', 'AI-powered tool that assists writers anything by manual input of data or information.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#60c395', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"30\"  height=\"30\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-ai\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M8 16v-6a2 2 0 1 1 4 0v6\" /><path d=\"M8 13h4\" /><path d=\"M16 8v8\" /></svg>', 1, 1, 1, 0, 0, 0, '2024-02-26 09:56:52'),
(3, 'Blog Idea &amp; Outline', 'blog-idea-outline', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Cloud product benefits\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"e.g. Software, Security\"}]', '1.5', 1, 2000, 'Blog Content', 'Generate blog topic ideas and outlines based on keywords and user preferences.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#6d87ee', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"22\"  height=\"22\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-article\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z\" /><path d=\"M7 8h10\" /><path d=\"M7 12h10\" /><path d=\"M7 16h10\" /></svg>', 1, 1, 1, 1, 0, 1, '2024-02-26 09:56:52'),
(4, 'Blog Intros', 'blog-intros', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"e.g. Cloud product benefits\"}]', '0.8', 1, 1000, 'Blog Content', 'Generates captivating and engaging blog introductions to hook readers and drive traffic', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#ca65e6', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(5, 'Blog Title', 'blog-title', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"What is your blog post about?\"}]', NULL, 1, NULL, 'Blog Content', 'Utilizes natural language processing to generate engaging and relevant blog titles', NULL, 0, 'asst_hxd4jlBzXi9gu1xQc9kyalav', NULL, NULL, NULL, NULL, '#281f56', NULL, 1, 1, 1, 0, 0, 1, '2024-09-09 21:10:59'),
(6, 'Blog Section', 'blog-section', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Tips for becoming a better writer\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"e.g. Science fiction\"}]', '0.8', 1, 3800, 'Blog Content', 'Generates high-quality and engaging blog sections using natural language processing and machine learning algorithms.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#aabe46', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(7, 'Business Ideas', 'business-ideas', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Interest\",\"placeholder\":\"e.g. Marketing\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Skills\",\"placeholder\":\"e.g. Communication, Creativity, Attention\"}]', '0.8', 1, 2000, 'Writing Tools', 'Advanced algorithms to analyze market trends and consumer behavior data to generate unique and profitable business ideas.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#59c851', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(8, 'Content Generator', 'content-generator', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Digital marketing business ideas\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"e.g. Data Analysis, Social Media, SEO\"}]', '0.8', 1, 3500, 'Blog Content', 'Creates high-quality content in various formats like articles, blogs, social media posts, and more.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#dd6969', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(9, 'Create Variants', 'create-variants', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"Description here\"}]', '0.8', 1, 3000, 'Blog Content', 'An AI-powered tool that generates new variants of existing products, designs, or content.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#53b4c1', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:49'),
(10, 'Cover Letter', 'cover-letter', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Job role\",\"placeholder\":\"e.g. Digital Marketing\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Job skills\",\"placeholder\":\"e.g. Data Analysis, Social Media, SEO\"}]', '0.8', 1, 2000, 'Email &amp; Letter', 'Writes effective cover letters by analyzing job descriptions, personalizing content, and providing feedback for enhancement.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#ab73e2', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(11, 'English Correction', 'english-correction', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"Write English here\"}]', '0.8', 1, 2000, 'Study Tools', 'An AI-powered tool that corrects English grammar and spelling errors to improve writing quality.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#cc6666', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:11'),
(12, 'Email and Message', 'email-and-message', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Key points\",\"placeholder\":\"About message\"}]', '0.8', 1, 2000, 'Email &amp; Letter', 'An AI-powered tool that assists in writing effective and persuasive emails and messages.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#c8bd41', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:42'),
(13, 'Facebook Ad Description', 'facebook-ad-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Product name\",\"placeholder\":\"About ad\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"Target keywords\"}]', '0.8', 1, 2000, 'Marketing', 'Maximize your ad performance with our AI-powered tool that optimizes your Facebook campaigns in real-time.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#0866ff', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"bi bi-facebook\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951\"/>\r\n</svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(14, 'Facebook Ad Variants', 'facebook-ad-variants', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"Describe your product\"}]', '0.8', 1, 2000, 'Marketing', 'Automatically creates multiple ad variations for advertisers to test and optimize their campaigns.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#0866ff', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"bi bi-facebook\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951\"/>\r\n</svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(15, 'Google Ad Description', 'google-ad-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Product name\",\"placeholder\":\"About ad\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"Target keywords\"}]', '0.8', 1, 2000, 'Marketing', 'Automatically generates Google Ad descriptions based on relevant keywords and ad targeting.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#85bc57', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(16, 'Google Ad Variants', 'google-ad-variants', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"About product\"}]', '0.8', 1, 2000, 'Marketing', 'An AI-powered tool that automatically generates multiple variations of Google ads to increase reach and engagement.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#cc5ca8', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(17, 'Google Search Ads', 'google-search-ads', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Product name\",\"placeholder\":\"e.g. SEO Analyzer Software\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Target keywords\",\"placeholder\":\"e.g. SEO Analyzer, SEO Checker\"}]', '0.8', 1, 2000, 'Marketing', 'Enhances the performance of Google Search Ads by automating bidding strategies and optimizing keywords', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#e16060', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(18, 'Hashtag Generator', 'hashtag-generator', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"Description here\"}]', '0.8', 1, 1000, 'Social Media', 'An AI-powered tool that generates relevant and popular hashtags for social media posts.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#60c7a8', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(19, 'Headline Generator', 'headline-generator', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"Topic here\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"Target keywords\"}]', '0.8', 1, 1000, 'Blog Content', 'Revolutionize your content marketing strategy with an AI-powered tool that generates attention-grabbing headlines in seconds.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#d770c9', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"22\"  height=\"22\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-heading\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M7 12h10\" /><path d=\"M7 5v14\" /><path d=\"M17 5v14\" /><path d=\"M15 19h4\" /><path d=\"M15 5h4\" /><path d=\"M5 19h4\" /><path d=\"M5 5h4\" /></svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(20, 'Invitation Letter', 'invitation-letter', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Purpose\",\"placeholder\":\"e.g. Attend a party\"}]', '0.8', 1, 2000, 'Email &amp; Letter', 'Automates the process of invitation letter writing by generating personalized and professional letters in a matter of seconds', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#7ecf6e', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(21, 'Keyword Extract', 'keyword-extract', 'You are an assistant for extracting and analyzing keywords from a given text. Your task is to identify the most relevant keywords and generate a table with the following columns for each keyword:\r\n\r\nKeyword: The extracted keyword or phrase.\r\nKeyword Score: A numerical score representing the relevance or effectiveness of the keyword.\r\nRating: A qualitative rating of the keyword, such as \"High,\" \"Medium,\" or \"Low.\"\r\nSearch Volume: The estimated number of searches for the keyword.\r\nThe table should be clear, organized, and easy to read. Each row should represent a distinct keyword and its associated data.', '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Text\",\"placeholder\":\"Enter your text here\"}]', '0.8', 1, 2000, 'Website', 'Extracts relevant keywords from text documents to improve search engine optimization (SEO) and content marketing strategies.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#5d95df', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"22\"  height=\"22\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-key\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z\" /><path d=\"M15 9h.01\" /></svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(22, 'Link Description', 'link-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"Describe your main theme\"}]', '0.8', 1, 2000, 'Website', 'Automatically generates product descriptions by analyzing product features and customer preferences.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#be6ed4', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(23, 'Meta Description', 'meta-description', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Meta title\",\"placeholder\":\"Meta title or keywords\"}]', '0.8', 1, 1000, 'Website', 'Generates optimized meta descriptions for websites, improving their search engine visibility and click-through rates.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#a4bb54', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(24, 'Meta Title', 'meta-title', NULL, '[{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"Target keywords or products\"}]', '0.8', 1, 1000, 'Website', 'Generates SEO-friendly meta titles for websites to improve search engine visibility and drive more traffic.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#7376ce', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(25, 'Offer Letter', 'offer-letter', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Job role\",\"placeholder\":\"e.g. Digital Marketing\"}]', '0.8', 1, 2000, 'Email &amp; Letter', 'AI-powered tool that automates the process of writing personalized and legally compliant offer letters.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#61b6cc', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(26, 'Paragraph Writing', 'paragraph-writing', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Nikola Tesla and his contributions\"}]', '0.8', 1, 2000, 'Study Tools', 'Generating high-quality paragraphs with relevant content and appropriate tone for various writing tasks', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#7b7ed5', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(27, 'Post Caption', 'post-caption', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"e.g. Nikola Tesla and his contributions history\"}]', '0.8', 1, 2000, 'Social Media', 'An advanced AI-powered tool that generates captivating and relevant captions for your social media posts with just a few clicks.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#ddc055', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(28, 'Product Name', 'product-name', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"About product\",\"placeholder\":\"Describe your product features\"}]', '0.8', 1, 2000, 'Marketing', 'AI-powered tool that helps businesses create unique and catchy product names with ease.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#e1cc66', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(29, 'Product Description', 'product-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Product name\",\"placeholder\":\"e.g. Makeup products\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"e.g. Cosmetic, Eyeshadow palette\"}]', '0.8', 1, 2000, 'Marketing', 'Utilizes natural language processing to generate compelling and optimized product descriptions for e-commerce businesses.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#6ecfa1', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:22'),
(30, 'Product Tagline', 'product-tagline', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"About product\",\"placeholder\":\"e.g. Improve the ranking of a website on search engine results\"}]', '0.8', 1, 1000, 'Marketing', 'An innovative AI-powered tool that generates compelling product taglines in seconds to boost your marketing campaigns.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#9789dc', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(31, 'Pros and Cons', 'pros-and-cons', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Product name\",\"placeholder\":\"e.g. Makeup products\"}]', '0.8', 1, 2000, 'Marketing', 'Pros and cons writing can help you easily identify the advantages and disadvantages of any given topic.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#e77474', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(32, 'FAQ Generator', 'faq-generator', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"About\",\"placeholder\":\"About product or service\"}]', '0.8', 1, 2000, 'Marketing', 'Automatically generates frequently asked questions (FAQs) based on user input and website content.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#99c15c', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:25'),
(33, 'Question Generator', 'question-generator', 'You are tasked with generating quiz questions. For each question:\r\n\r\nWrite the question in bold. Do not add question numbers or lists.\r\nProvide the answer options immediately below the question in a clear and unnumbered format.\r\nIndicate the correct answer on a new line, starting with \"Correct:\" followed by the correct option.\r\n\r\nExample:\r\n\r\nWhat is the capital of France?\r\n\r\na) Berlin\r\nb) Paris\r\nc) Rome\r\nd) Madrid\r\n\r\nCorrect: b) Paris\r\n', '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Becoming a better writer\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"e.g. Science fiction\"}]', '0.8', 1, 2000, 'Study Tools', 'AI-powered tool that uses natural language processing algorithms to generate high-quality questions for any given topic or document.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#db51a2', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"22\"  height=\"22\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"3\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-question-mark\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M8 8a3.5 3 0 0 1 3.5 -3h1a3.5 3 0 0 1 3.5 3a3 3 0 0 1 -2 3a3 4 0 0 0 -2 4\" /><path d=\"M12 19l0 .01\" /></svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(34, 'Testimonial and Review', 'testimonial-and-review', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Product name\",\"placeholder\":\"e.g. Keyboard\"},{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"About product\",\"placeholder\":\"e.g. Logitech wireless keyboard k270\"}]', '0.8', 1, 2000, 'Marketing', 'An AI-powered tool that generates high-quality testimonials and reviews for businesses.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#7984d7', NULL, 1, 1, 1, 0, 0, 1, '2024-03-10 06:56:19'),
(35, 'Short Message', 'short-message', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Birthday wish\"}]', '0.8', 1, 1000, 'Email &amp; Letter', 'Generates concise and effective messages for various purposes with minimal effort.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#b16ec9', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(36, 'Story Writing', 'story-writing', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Nikola Tesla and his contributions\"}]', '0.8', 1, 3800, 'Writing Tools', 'Generates story outlines and suggests plot twists, character traits, and settings for writers.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#eeae53', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:00'),
(37, 'Summarize Text', 'summarize-text', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"Your text here\"}]', '0.8', 1, 2000, 'Study Tools', 'Natural language processing algorithms to extract the most important information from a text and summarize it in a concise format.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#b5ce5a', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(38, 'Transformation', 'transformation', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Sentence\",\"placeholder\":\"Your sentence here\"}]', '0.8', 1, 2000, 'Study Tools', 'Transforms sentences by generating alternative versions with similar meanings and structures.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#d3a555', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(39, 'Video Description', 'video-description', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Video title\",\"placeholder\":\"About video\"}]', '0.8', 1, 2000, 'Videos', 'Generates descriptive text for videos, enhancing accessibility and improving searchability.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#65c95e', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"14\"  height=\"14\"  viewBox=\"0 0 24 24\"  fill=\"currentColor\"  class=\"icon icon-tabler icons-tabler-filled icon-tabler-player-play\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M6 4v16a1 1 0 0 0 1.524 .852l13 -8a1 1 0 0 0 0 -1.704l-13 -8a1 1 0 0 0 -1.524 .852z\" /></svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(40, 'Youtube Video Description', 'youtube-video-description', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Video title\",\"placeholder\":\"About video\"}]', '0.8', 1, 2000, 'Videos', 'Automatically generates optimized video descriptions for YouTube content creators.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#f01919', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"14\"  height=\"14\"  viewBox=\"0 0 24 24\"  fill=\"currentColor\"  class=\"icon icon-tabler icons-tabler-filled icon-tabler-player-play\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M6 4v16a1 1 0 0 0 1.524 .852l13 -8a1 1 0 0 0 0 -1.704l-13 -8a1 1 0 0 0 -1.524 .852z\" /></svg>', 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:06'),
(41, 'Outline Generator', 'outline-generator', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Nikola Tesla and his contributions\"}]', '0.8', 1, 2000, 'Study Tools', 'Generate outlines for written content, allowing for faster and more organized writing.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#c86abb', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(42, 'Keyword Generator', 'keyword-generator', 'You are an assistant for generating keyword analysis reports. For each keyword provided, you need to create a table that includes the following columns:\r\n\r\nKeyword: The keyword or phrase being analyzed.\r\nKeyword Score: A numerical score representing the relevance or effectiveness of the keyword.\r\nRating: A qualitative rating of the keyword, such as \"High,\" \"Medium,\" or \"Low.\"\r\nSearch Volume: The estimated number of searches for the keyword.\r\nThe table should be presented in a clean and organized format. Each row should represent a separate keyword and its associated data.', '[{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Primary keyword\",\"placeholder\":\"Your primary keyword\"}]', '0.8', 1, 1000, 'Blog Content', 'Generates high-quality keywords and phrases for SEO and PPC campaigns.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#6bce69', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"22\"  height=\"22\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-key\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z\" /><path d=\"M15 9h.01\" /></svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(43, 'Resume Writing', 'resume-writing', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Job Sector\",\"placeholder\":\"e.g. Digital Marketing\"}]', '0.8', 1, 2000, 'Email &amp; Letter', 'An AI-powered tool that utilizes machine learning and natural language processing to generate professional and effective resumes.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#b7ce46', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:31'),
(44, 'Profile Bio', 'profile-bio', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"About you\",\"placeholder\":\"e.g. Digital marketing expert\"}]', '0.8', 1, 2000, 'Social Media', 'Analyzes and profiles social media bio to provide insights on personality, interests and behaviors.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#adc559', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(45, 'Instagram Post Caption', 'instagram-post-caption', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"Post topic\"}]', '0.8', 1, 1000, 'Social Media', 'Generates catchy and engaging captions for Instagram posts automatically.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#df7272', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:17'),
(46, 'Facebook Post Description', 'facebook-post-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Birthday wish\"}]', '0.8', 1, 2000, 'Social Media', 'Analyzes and suggests effective Facebook post descriptions based on content and audience engagement.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#0866ff', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"bi bi-facebook\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951\"/>\r\n</svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(47, 'Linkedin Post Description', 'linkedin-post-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Birthday wish\"}]', '0.8', 1, 2000, 'Social Media', 'Optimizes your LinkedIn posts for maximum engagement and reach, helping you grow your professional network and increase your visibility', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#0a66c2', '<svg fill=\"currentColor\" height=\"18\" width=\"18\" version=\"1.1\" id=\"Layer_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" viewBox=\"0 0 310 310\" xml:space=\"preserve\">\r\n  <g id=\"XMLID_801_\">\r\n    <path id=\"XMLID_802_\" d=\"M72.16,99.73H9.927c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5H72.16c2.762,0,5-2.238,5-5V104.73 C77.16,101.969,74.922,99.73,72.16,99.73z\"/>\r\n    <path id=\"XMLID_803_\" d=\"M41.066,0.341C18.422,0.341,0,18.743,0,41.362C0,63.991,18.422,82.4,41.066,82.4 c22.626,0,41.033-18.41,41.033-41.038C82.1,18.743,63.692,0.341,41.066,0.341z\"/>\r\n    <path id=\"XMLID_804_\" d=\"M230.454,94.761c-24.995,0-43.472,10.745-54.679,22.954V104.73c0-2.761-2.238-5-5-5h-59.599 c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5h62.097c2.762,0,5-2.238,5-5v-98.918c0-33.333,9.054-46.319,32.29-46.319 c25.306,0,27.317,20.818,27.317,48.034v97.204c0,2.762,2.238,5,5,5H305c2.762,0,5-2.238,5-5V194.995 C310,145.43,300.549,94.761,230.454,94.761z\"/>\r\n  </g>\r\n</svg>', 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:14'),
(48, 'Resignation Letter', 'resignation-letter', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Job Role\",\"placeholder\":\"e.g. Digital Marketing\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Reason\",\"placeholder\":\"e.g. Better opportunity, Illnesses\"}]', '0.8', 1, 2000, 'Email &amp; Letter', 'Resignation letter writing tool that helps employees draft professional and personalized letters in a matter of minutes.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#4bce61', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(49, 'Speeches Writing', 'speeches-writing', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"e.g. Benefits of healthy living\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Key point\",\"placeholder\":\"e.g. Health, Life\"}]', '0.8', 1, 3000, 'Writing Tools', 'An AI-powered tool that converts spoken words into written text with high accuracy and speed.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#a967c1', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(50, 'Home Work', 'home-work', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"About home work\",\"placeholder\":\"Describe your home works\"}]', '0.8', 1, 3000, 'Study Tools', 'Assists with homework writing by providing suggestions for grammar, style, and content improvements.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#d5ae44', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(51, 'Job Description', 'job-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Job Role\",\"placeholder\":\"e.g. Digital Marketing\"}]', '0.8', 1, 2000, 'Email &amp; Letter', 'Streamlines job description writing by analyzing industry-specific language and providing optimization suggestions', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#8472df', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:36'),
(52, 'Song Lyrics', 'song-lyrics', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Song Idea\",\"placeholder\":\"About song\"}]', '0.8', 1, 2000, 'Writing Tools', 'An AI-powered tool that uses natural language processing to generate catchy and meaningful song lyrics.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#c3b946', NULL, 1, 1, 1, 1, 0, 1, '2024-10-17 19:32:04'),
(53, 'Landing Page', 'landing-page', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Product details\",\"placeholder\":\"Describe your product\"}]', '0.8', 1, 3000, 'Website', 'Automates the process of creating high-converting landing pages for digital marketers and businesses.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#abc256', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:03'),
(54, 'Video Script', 'video-script', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Video title\",\"placeholder\":\"Describe your scripts\"}]', '0.8', 1, 2000, 'Videos', 'Generates engaging and personalized video script for maximum audience retention.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#559bdd', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(55, 'Video Title', 'video-title', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Video title\",\"placeholder\":\"About video\"}]', '0.8', 1, 2000, 'Videos', 'Generates attention grabbing video titles for enhanced engagement and visibility.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#e6ad4c', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(56, 'Essay Writing', 'essay-writing', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Essay Topic\",\"placeholder\":\"e.g. Nikola Tesla and his contributions\"}]', '0.8', 1, 2000, 'Study Tools', 'Assists students in improving their essay writing skills by providing personalized feedback and suggestions.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#5cc7a7', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(57, 'Copy Ad Variants', 'copy-ad-variants', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Ad Description\",\"placeholder\":\"Describe your ad\"}]', '0.8', 1, 3000, 'Marketing', 'Copy Ad Variants is an AI-powered tool that creates multiple variations of ad copy to optimize ad performance.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#d173d3', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(58, 'Study Notes', 'study-notes', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Topic\",\"placeholder\":\"Describe your note\"}]', '0.8', 1, 3000, 'Study Tools', 'Designed to analyze and suggest improvements for note-taking, helping students to create effective study notes.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#54c08d', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(59, 'Text to Code', 'text-to-code', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Text\",\"placeholder\":\"e.g. Create country list by PHP array.e.g. Sql to select last month records.e.g. Javascript to print 1-100.e.g. Node js http get request.\"}]', '1', 1, 3000, 'Code Tools', 'AI-powered tool that automatically converts natural language descriptions into code.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#0a0a0a', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"20\"  height=\"20\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-code\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M7 8l-4 4l4 4\" /><path d=\"M17 8l4 4l-4 4\" /><path d=\"M14 4l-4 16\" /></svg>', 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:46'),
(60, 'Dialogue and Conversation', 'dialogue-and-conversation', NULL, '[{\"type\":\"input\",\"key\":\"topic\",\"label\":\"Dialogue Topic\",\"placeholder\":\"e.g. Benefit of reading book\"}]', '0.8', 1, 2000, 'Study Tools', 'Designed to facilitate natural and engaging dialogue and conversation between humans and machines.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#5f8ace', NULL, 1, 1, 1, 0, 0, 1, '2024-03-26 21:13:12'),
(61, 'Narration Change', 'narration-change', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Sentences\",\"placeholder\":\"Your sentences\"}]', '0.8', 1, 2000, 'Study Tools', 'Change the narration style of written content to fit different personas and target audiences.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#9fbf45', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(62, 'Blog Conclusion', 'blog-conclusion', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"About blog\"}]', '0.8', 1, 1000, 'Blog Content', 'This AI-powered tool can generate compelling and relevant conclusions for your blog posts.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#57acd6', NULL, 1, 1, 1, 0, 0, 1, '2024-10-24 15:20:22'),
(63, 'Content Rewriter', 'content-rewriter', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Content\",\"placeholder\":\"Input your text to rewrite\"}]', '0.8', 1, 3000, 'Blog Content', 'Rewrite existing content by using advanced algorithms and natural language processing to create unique and engaging content.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#9366d6', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:58:28'),
(64, 'Code Explainer', 'code-explainer', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Code\",\"placeholder\":\"Enter your code\"}]', '0.8', 1, 3000, 'Code Tools', 'Code Explainer is an AI-powered tool that helps developers understand and explain complex code structures.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#44c59a', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(65, 'Plagiarism Checker', 'plagiarism-checker', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Text\",\"placeholder\":\"Input your text\"}]', '0.8', 1, 3000, 'Blog Content', 'Plagiarism Checker is a tool that analyzes written content and identifies potential instances of plagiarism.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#ae69d3', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:58:17'),
(66, 'Call To Action', 'call-to-action', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Description\",\"placeholder\":\"Description here\"}]', '0.8', 1, 3000, 'Marketing', 'A Call To Action is a clear and compelling request for the audience to take a specific action, such as making a purchase, signing up or visiting a website.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#df893a', '<svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"22\"  height=\"22\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-phone-outgoing\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2c-8.072 -.49 -14.51 -6.928 -15 -15a2 2 0 0 1 2 -2\" /><path d=\"M15 5h6\" /><path d=\"M18.5 7.5l2.5 -2.5l-2.5 -2.5\" /></svg>', 1, 1, 1, 1, 0, 1, '2024-05-10 21:16:38'),
(67, 'Product Title', 'product-title', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"About product\",\"placeholder\":\"About product and features\"}]', '0.8', 1, 2000, 'Marketing', 'An AI-powered tool that can generate optimized product titles to improve SEO and increase sales.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#5dbecb', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(68, 'Upwork Profile Description', 'upwork-profile-description', NULL, '[{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Your skills\",\"placeholder\":\"e.g. Data Analysis, Social Media, SEO\"}]', '0.8', 1, 1200, 'Writing Tools', 'Generator capable of seamlessly creating profiles tailored to your unique skills and expertise.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#91ba45', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(69, 'Fiverr Gig Description', 'fiverr-gig-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Gig title\",\"placeholder\":\"About gig\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Category\",\"placeholder\":\"Relevant to the services category and tags\"}]', '0.8', 1, 2000, 'Writing Tools', 'Gig creation offers efficient and personalized gig creation, saving time and increasing productivity for freelancers.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#54c993', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(70, 'Tweet Generator', 'tweet-generator', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"About tweet\"}]', '0.8', 1, 500, 'Social Media', 'Assists students in improving their essay writing skills by providing personalized feedback and suggestions.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#31adde', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(71, 'TikTok Video Script', 'tiktok-video-script', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Topic\",\"placeholder\":\"About TikTok\"}]', '0.8', 1, 3000, 'Videos', 'Write engaging and personalized TikTok video script for maximum audience retention.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#0a0a0a', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"18\" height=\"18\" fill=\"currentColor\" class=\"bi bi-tiktok\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z\"/>\r\n</svg>', 1, 1, 1, 1, 0, 1, '2024-03-10 06:56:09'),
(72, 'Newsletter Writing', 'newsletter-writing', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"About newsletter\",\"placeholder\":\"Details about your newsletter\"}]', '0.8', 1, 1200, 'Email &amp; Letter', 'AI-powered tool that writing effective and attractive newsletter for maximum audience attention.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#c84a41', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(73, 'Linkedin Ad Description', 'linkedin-ad-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Product name\",\"placeholder\":\"About ad\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Keywords\",\"placeholder\":\"Target keywords\"}]', '0.8', 1, 2000, 'Marketing', 'Our AI-powered tool that optimizes your Linkedin campaigns and catch more audience attraction.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#0a66c2', '<svg fill=\"currentColor\" height=\"18\" width=\"18\" version=\"1.1\" id=\"Layer_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" viewBox=\"0 0 310 310\" xml:space=\"preserve\">\r\n  <g id=\"XMLID_801_\">\r\n    <path id=\"XMLID_802_\" d=\"M72.16,99.73H9.927c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5H72.16c2.762,0,5-2.238,5-5V104.73 C77.16,101.969,74.922,99.73,72.16,99.73z\"/>\r\n    <path id=\"XMLID_803_\" d=\"M41.066,0.341C18.422,0.341,0,18.743,0,41.362C0,63.991,18.422,82.4,41.066,82.4 c22.626,0,41.033-18.41,41.033-41.038C82.1,18.743,63.692,0.341,41.066,0.341z\"/>\r\n    <path id=\"XMLID_804_\" d=\"M230.454,94.761c-24.995,0-43.472,10.745-54.679,22.954V104.73c0-2.761-2.238-5-5-5h-59.599 c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5h62.097c2.762,0,5-2.238,5-5v-98.918c0-33.333,9.054-46.319,32.29-46.319 c25.306,0,27.317,20.818,27.317,48.034v97.204c0,2.762,2.238,5,5,5H305c2.762,0,5-2.238,5-5V194.995 C310,145.43,300.549,94.761,230.454,94.761z\"/>\r\n  </g>\r\n</svg>', 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(74, 'Upwork Project Description', 'upwork-project-description', NULL, '[{\"type\":\"text\",\"key\":\"topic\",\"label\":\"Project name\",\"placeholder\":\"\"},{\"type\":\"text\",\"key\":\"keyword\",\"label\":\"Required skills\",\"placeholder\":\"\"}]', '0.8', 1, 2000, 'Writing Tools', 'Generating high-quality description with relevant project and appropriate skill for various tasks.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#4bce79', NULL, 1, 1, 1, 0, 0, 1, '2024-02-26 09:56:52'),
(75, 'Upwork Proposal', 'upwork-proposal', NULL, '[{\"type\":\"textarea\",\"key\":\"text\",\"label\":\"Project Details\",\"placeholder\":\"Project details or subject\"}]', '0.8', 1, 1200, 'Writing Tools', 'AI to writing effective and attractive proposal for maximum buyer attention.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '#3cb0e2', NULL, 1, 1, 1, 1, 0, 1, '2024-03-10 06:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `description`) VALUES
(1, 'John Vincent', 'Visual Designer', 'The product is excellent. It allows you to input your content and specify the desired outcome, and it generates text that perfectly matches the required tone and style. This is extremely helpful in generating the kind of text you need.'),
(2, 'Kevin Carter', 'Sales Representative', 'The text and image generation feature of this app is incredibly user-friendly. All you have to do is input what you already have and specify how you want it to be portrayed, and the app will generate a result that perfectly matches your desired text and tone.'),
(3, 'Steven Roberts', 'Marketing Manager', 'Overall, I found the text and image generation app to be very user-friendly and efficient. It allows you to input your desired content and format, and in return, it generates a result that perfectly aligns with my requirements.'),
(4, 'Anthony Hill', 'Market Research Analyst', 'User-friendly platform, you simply input what you have and specify the desired outcome, and it generates a result that is extremely helpful in creating the desired text and tone. This is extremely helpful when it comes to creating content that aligns with your specific needs.'),
(5, 'Erica Davis', 'Brand Manager', 'I find this platform to be extremely useful for marketing purposes. It allows you to input the information and specifications you have, and it generates a result that greatly assists in creating the desired text and tone. The platform\'s ability to produce tailored content is truly valuable for generating effective marketing materials.'),
(6, 'Thomas Flores', 'SEO Analyst', 'The content provided is well-optimized for SEO. The app allows you to input your desired specifications and it generates text that perfectly aligns with your needs in terms of both content and tone. It proves to be extremely helpful in generating the kind of text you require.');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` varchar(50) NOT NULL,
  `ref_id` varchar(50) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `assistant_id` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tones`
--

CREATE TABLE `tones` (
  `name` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tones`
--

INSERT INTO `tones` (`name`, `title`, `status`) VALUES
('Appreciative', '', 1),
('Assertive', '', 1),
('Awestruck', '', 1),
('Bold', '', 0),
('Casual', '', 1),
('Cautionary', '', 1),
('Convincing', '', 1),
('Dramatic', '', 0),
('Enthusiastic', '', 0),
('Formal', '', 1),
('Friendly', '', 0),
('Funny', '', 1),
('Humble', '', 0),
('Humorous', '', 1),
('Inspirational', '', 1),
('Joyful', '', 1),
('Motivating', '', 1),
('Passionate', '', 0),
('Professional', '', 1),
('Romantic', '', 1),
('Sadness', '', 0),
('Sarcastic', '', 0),
('Worried', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) NOT NULL,
  `method` varchar(30) DEFAULT NULL,
  `currency` varchar(10) NOT NULL,
  `amount` varchar(15) DEFAULT '0',
  `tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `plan_id` int(11) NOT NULL,
  `payment_id` varchar(80) DEFAULT NULL,
  `payment_status` tinyint(1) DEFAULT 0,
  `offline_payment` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usages`
--

CREATE TABLE `usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `words` int(11) NOT NULL DEFAULT 0,
  `images` int(11) NOT NULL DEFAULT 0,
  `documents` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `password` varchar(72) DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `session` varchar(32) DEFAULT NULL,
  `api_token` varchar(50) DEFAULT NULL,
  `openai_status` tinyint(1) NOT NULL DEFAULT 0,
  `anthropic_status` tinyint(4) NOT NULL DEFAULT 0,
  `openai_apikey` tinytext DEFAULT NULL,
  `anthropic_apikey` tinytext DEFAULT NULL,
  `default_chat_model` varchar(50) DEFAULT NULL,
  `default_image_model` varchar(50) DEFAULT NULL,
  `default_analyst_model` varchar(50) DEFAULT NULL,
  `default_article_model` varchar(50) DEFAULT NULL,
  `profile_image` tinytext DEFAULT NULL,
  `search_engine_id` varchar(100) DEFAULT NULL,
  `search_engine_apikey` tinytext DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `billing_address` varchar(50) DEFAULT NULL,
  `billing_city` varchar(30) DEFAULT NULL,
  `billing_state` varchar(30) DEFAULT NULL,
  `billing_country` varchar(30) DEFAULT NULL,
  `billing_postal` varchar(12) DEFAULT NULL,
  `payment_method` varchar(30) DEFAULT NULL,
  `customer_id` varchar(80) DEFAULT NULL,
  `subscription_id` varchar(80) DEFAULT NULL,
  `subscription_status` tinyint(4) NOT NULL DEFAULT 0,
  `words_generated` int(11) NOT NULL DEFAULT 0,
  `images_generated` int(11) NOT NULL DEFAULT 0,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `referral_id` varchar(20) DEFAULT NULL,
  `plan_id` int(11) NOT NULL DEFAULT 0,
  `words` varchar(20) DEFAULT '0',
  `images` int(11) DEFAULT 0,
  `expired` datetime DEFAULT NULL,
  `logged` datetime NOT NULL DEFAULT current_timestamp(),
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `session`, `api_token`, `openai_status`, `anthropic_status`, `openai_apikey`, `anthropic_apikey`, `default_chat_model`, `default_image_model`, `default_analyst_model`, `default_article_model`, `profile_image`, `search_engine_id`, `search_engine_apikey`, `company`, `billing_address`, `billing_city`, `billing_state`, `billing_country`, `billing_postal`, `payment_method`, `customer_id`, `subscription_id`, `subscription_status`, `words_generated`, `images_generated`, `balance`, `referral_id`, `plan_id`, `words`, `images`, `expired`, `logged`, `created`) VALUES
(1001, 'Admin', 'support@mxwriter.com', '$2y$10$TyBVns1vqNTLCsuHKpLVqOGTUGPcTzqFePTwJsJJeIdhUA/mWe4wW', 1, 1, '67bc3217a4400', '', 0, 0, '', NULL, NULL, 'dall-e-2', NULL, NULL, NULL, NULL, NULL, NULL, 'Address line1', 'City name1', 'State name1', 'Country name1', '657896', NULL, NULL, NULL, 1, 83998, 15, 5.80, '1919826649', 8, '29981487', 2994, '2026-02-19 05:39:14', '2025-02-24 00:47:19', '2025-02-14 12:06:21'),
(1002, 'Sohel Rana', 'sohel6bd@gmail.com', '$2y$10$aDC02ByELjvEThboihV9..U.f3KjcHxbBU8w35JINLg2GQ8DKdnsy', 1, 1, '67b7c7e17dd9c', '', 0, 0, '', NULL, NULL, 'dall-e-2', NULL, NULL, NULL, NULL, NULL, NULL, 'Address line1', 'City name1', 'State name1', 'Country name1', '657896', NULL, NULL, NULL, 1, 74203, 12, 5.80, '1919826649', 8, '29991282', 2997, '2026-02-19 05:39:14', '2025-02-24 02:02:09', '2025-02-14 12:06:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analysis`
--
ALTER TABLE `analysis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `assistants`
--
ALTER TABLE `assistants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklists`
--
ALTER TABLE `blacklists`
  ADD PRIMARY KEY (`words`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chat_assistants`
--
ALTER TABLE `chat_assistants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chat_history`
--
ALTER TABLE `chat_history`
  ADD KEY `chat_id` (`chat_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider` (`provider`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prompts`
--
ALTER TABLE `prompts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `recent_history`
--
ALTER TABLE `recent_history`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ref_id` (`ref_id`);

--
-- Indexes for table `tones`
--
ALTER TABLE `tones`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usages`
--
ALTER TABLE `usages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_assistants`
--
ALTER TABLE `chat_assistants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `prompts`
--
ALTER TABLE `prompts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=388;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1252;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1556;

--
-- AUTO_INCREMENT for table `usages`
--
ALTER TABLE `usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1014;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
