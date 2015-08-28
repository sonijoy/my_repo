<?php
/*
Template Name: Insert Sponsors

SELECT sponsor.id, sponsor.created_at, sponsor.name, sponsor.website, sponsor.logo_file, channel.id AS  'channel'
FROM sponsor
LEFT JOIN channel ON channel.id = sponsor.channel_id
ORDER BY  `sponsor`.`id` ASC 

$sponsors = array(
  array('id'=>'1108','created_at'=>'2013-04-22 21:31:26','name'=>'Spotlight Youth Theater in Rockford','website'=>'http://www.spotlight.org/rms13_lesmiserables','logo_file'=>'465ceb9c8e21584158534bccce5a4f43f74adb6d.jpg','channel'=>'212'),
  array('id'=>'1109','created_at'=>'2013-04-23 20:19:48','name'=>'BSC Contracting','website'=>'http://www.bsccontractingllc.com/index.html','logo_file'=>'f656304e2c3312608c70a38d01533807dd3950f9.jpg','channel'=>'221'),
  array('id'=>'1110','created_at'=>'2013-04-24 05:41:50','name'=>'Tri State Athletic Club','website'=>'http://www.tristateathleticclub.com/','logo_file'=>'c42db2de096193d94b010ac4502f47a193251bf3.jpg','channel'=>'211'),
  array('id'=>'1111','created_at'=>'2013-04-24 05:48:30','name'=>'Body Boutique','website'=>'http://thebodyboutiquedayspa.com/','logo_file'=>'4774cc85f8067631235a2771004c5a9e376b663b.jpg','channel'=>'211'),
  array('id'=>'1112','created_at'=>'2013-04-24 05:51:35','name'=>'Allstate Insurance','website'=>'','logo_file'=>'8df7de64dd3069cec5620112461d71e1d1ffe4cd.jpg','channel'=>'211'),
  array('id'=>'1114','created_at'=>'2013-04-24 08:08:21','name'=>'Action Technology Services','website'=>'http://www.actiontechservices.com','logo_file'=>'2f4db5c21fa1fb62feb171be87d65f8a1a60b018.gif','channel'=>'238'),
  array('id'=>'1116','created_at'=>'2013-04-24 12:20:25','name'=>'L.A.Plastic Surgery','website'=>'http://www.drlacerna.com/','logo_file'=>'ee39e4b67342a6e44af2d53c712ad658d34238ec.png','channel'=>'232'),
  array('id'=>'1121','created_at'=>'2013-04-27 14:51:13','name'=>'The UPS Store','website'=>'http://www.theupsstorelocal.com/5089/','logo_file'=>'ae2db23b2508ad773279409411a4a3698069a63d.jpg','channel'=>'226'),
  array('id'=>'1123','created_at'=>'2013-04-27 21:29:07','name'=>'Big Day TV on facebook','website'=>'https://www.facebook.com/pages/Rockford-bigdaytv/423470277739892','logo_file'=>'6cc6a5089be95288d071208822052739b3c2991a.jpg','channel'=>'212'),
  array('id'=>'1124','created_at'=>'2013-04-29 18:36:51','name'=>'Pro Buff','website'=>'','logo_file'=>'39360e6fb83d200eea55715101e9ddd27e76f7fb.jpg','channel'=>'232'),
  array('id'=>'1125','created_at'=>'2013-04-30 20:49:09','name'=>'Edgewater Real Estate','website'=>'http://edgewaterrealestateami.com/','logo_file'=>'16e6a356d510c774043c502b4b1bae07694bd33b.jpg','channel'=>'232'),
  array('id'=>'1126','created_at'=>'2013-05-05 07:18:20','name'=>'Meyer Construction Company','website'=>'https://www.facebook.com/travis.meyer.186?ref=ts&fref=ts','logo_file'=>'8f4e5b6daf8fd3b60d04fea7c3b17f1eead6084e.jpg','channel'=>'131'),
  array('id'=>'1127','created_at'=>'2013-05-08 06:37:20','name'=>'Heartland CCW - Mike Jenkins','website'=>'http://www.heartlandccw.com/','logo_file'=>'817dda3d51479bf9ba845477025f62deff0a78a0.jpg','channel'=>'221'),
  array('id'=>'1128','created_at'=>'2013-05-08 06:38:58','name'=>'Pyramid Pharmacy','website'=>'http://www.pyramidrx.net/','logo_file'=>'f836afafe669fc7c720788870542398a22f9ede8.jpg','channel'=>'221'),
  array('id'=>'1129','created_at'=>'2013-05-08 06:41:14','name'=>'Capitol Commission','website'=>'http://www.capitolcom.org/missouri','logo_file'=>'420d2f35cf9ced7a2018fbfe26aa44d8679bc3a3.jpg','channel'=>'221'),
  array('id'=>'1130','created_at'=>'2013-05-08 06:42:24','name'=>'Switch FM ','website'=>'http://www.kmfc.com/','logo_file'=>'df132fc7d7b2065121ac4fd752a70436f5134343.jpg','channel'=>'221'),
  array('id'=>'1131','created_at'=>'2013-05-08 06:43:25','name'=>'Pregnancy Help Center','website'=>'http://pregnancyhelpcenterofcmo.org/','logo_file'=>'3efdcd1da71cb8ee90695dc887007129aa90e3e6.jpg','channel'=>'221'),
  array('id'=>'1132','created_at'=>'2013-05-08 06:45:22','name'=>'World Vision ','website'=>'http://www.worldvision.org/','logo_file'=>'3d756733fa75acf6eb506a7e8ed66c60edff4186.jpg','channel'=>'221'),
  array('id'=>'1133','created_at'=>'2013-05-08 06:47:22','name'=>'Gospel for Asia','website'=>'http://www.gfa.org/','logo_file'=>'cdcde51fc6849210b4ea091bb242b46d85ce714d.jpg','channel'=>'221'),
  array('id'=>'1134','created_at'=>'2013-05-08 06:48:09','name'=>'Concord Baptist Church','website'=>'http://www.concordjc.org/','logo_file'=>'8ef94660424e4a7751fb7f793367da3aa143dddd.jpg','channel'=>'221'),
  array('id'=>'1135','created_at'=>'2013-05-08 06:48:51','name'=>'Capital Idea TV','website'=>'https://www.facebook.com/pages/Capital-Idea-TV/512336775478854','logo_file'=>'9b493a846f9313933ddc26278917553a097bf56c.jpg','channel'=>'221'),
  array('id'=>'1136','created_at'=>'2013-05-08 06:50:37','name'=>'Stained Glass Theatre','website'=>'http://www.sgtmidmo.org/','logo_file'=>'5cc57a50ac2cb097a2ddcb52a30f852596aac440.jpg','channel'=>'221'),
  array('id'=>'1137','created_at'=>'2013-05-08 06:52:39','name'=>'Bill Wise, SendOutCards','website'=>'https://www.sendoutcards.com/119844/','logo_file'=>'30d193785c4d04cc389e0694cecc4be6c6e2f917.jpg','channel'=>'221'),
  array('id'=>'1138','created_at'=>'2013-05-08 07:59:12','name'=>'Sheps South Side','website'=>'http://www.shepssouthside.com/','logo_file'=>'1b601aa9aa5aba7306188136a491ddeb938f2f9c.jpg','channel'=>'221'),
  array('id'=>'1139','created_at'=>'2013-05-09 13:56:41','name'=>'Ozarks Football League','website'=>'http://www.ozarksfootball.com/','logo_file'=>'28c4b4a2ec11871ec90a7822a7e6f80ce2204b97.jpg','channel'=>'131'),
  array('id'=>'1140','created_at'=>'2013-05-10 08:09:27','name'=>'We Never Sleep','website'=>'http://www.facebook.com/richmondmotv','logo_file'=>'5138e2dc209c7c42aa80231eac994e07a23cc29a.jpg','channel'=>'241'),
  array('id'=>'1141','created_at'=>'2013-05-10 08:20:54','name'=>'Station sponsorship','website'=>'http://www.facebook.com/richmondmotv','logo_file'=>'4addb26519fe7d4daecfce427020eb62eeb06f09.jpg','channel'=>'241'),
  array('id'=>'1142','created_at'=>'2013-05-10 08:25:14','name'=>'Your Ad Here','website'=>'http://www.facebook.com/richmondmotv','logo_file'=>'7fc6bf137c17934152a17ac1b5218df46a1c04fc.jpg','channel'=>'241'),
  array('id'=>'1143','created_at'=>'2013-05-10 08:26:49','name'=>'Business a Little Slow?','website'=>'http://www.facebook.com/richmondmotv','logo_file'=>'b3d2a2cc9c4985476ca0846f80c8f7ec03ab4434.jpg','channel'=>'241'),
  array('id'=>'1149','created_at'=>'2013-05-10 19:28:32','name'=>'Pam King Insurance','website'=>'','logo_file'=>'db115b561d786045d1bb71a5cfcf27d9bbbb4db1.jpg','channel'=>'250'),
  array('id'=>'1150','created_at'=>'2013-05-10 19:29:49','name'=>'Corner Cafe','website'=>'','logo_file'=>'b3008abd552bc2d293391b72f27033eda8d3db98.jpg','channel'=>'250'),
  array('id'=>'1152','created_at'=>'2013-05-10 19:43:12','name'=>'Pam King Insurance','website'=>'','logo_file'=>'6916cec37a563885870f6be1c1c51457c691498f.jpg','channel'=>'75'),
  array('id'=>'1153','created_at'=>'2013-05-10 19:43:35','name'=>'Corner Cafe','website'=>'','logo_file'=>'fad1118264b9cb0fc0553d575ed8f184c9302f78.jpg','channel'=>'75'),
  array('id'=>'1156','created_at'=>'2013-05-11 04:06:05','name'=>'Sky Tanning Studio is Now Indulge Full Body Spa','website'=>'','logo_file'=>'2fe3574d013ed006b19458ed59a890d4baed7089.jpg','channel'=>'75'),
  array('id'=>'1159','created_at'=>'2013-05-11 05:14:13','name'=>'Peoples Trust & Savings Bank','website'=>'http://www.peoplesbank-in.com/','logo_file'=>'6319978edf6d0f52b15776c206276c860838cb10.jpg','channel'=>'196'),
  array('id'=>'1162','created_at'=>'2013-05-11 09:10:32','name'=>'Peerless Products','website'=>'http://www.peerless-usa.com/','logo_file'=>'9e030de177af735aef9d1942ea82d26e8add5f36.png','channel'=>'84'),
  array('id'=>'1163','created_at'=>'2013-05-11 09:11:42','name'=>'WalMart','website'=>'http://www.walmart.com','logo_file'=>'54c8c96e6b2c6346234bbecbc10d9ee46819e5cb.png','channel'=>'84'),
  array('id'=>'1164','created_at'=>'2013-05-11 09:13:34','name'=>'Hill Street Recycling','website'=>'','logo_file'=>'4f5125cea7eb2c3ac8793f15c71ae1aba70c8c1e.jpg','channel'=>'84'),
  array('id'=>'1165','created_at'=>'2013-05-11 09:14:25','name'=>'Fort Scott COmmunity College','website'=>'http://www.fortscott.edu','logo_file'=>'8214fa21c95e404d7b9df030bb6e49f9eaa7eaff.jpg','channel'=>'84'),
  array('id'=>'1166','created_at'=>'2013-05-11 09:23:49','name'=>'Fort Scott Roofing','website'=>'http://www.theshop-roofing.com','logo_file'=>'c2c8a0ef5a6f912833f7f4b4a35b42aed3454e7e.jpg','channel'=>'84'),
  array('id'=>'1167','created_at'=>'2013-05-11 09:25:44','name'=>'Cobalt Medplans','website'=>'http://www.cobaltmedplans.com/','logo_file'=>'9a9c437898e5bb30dc0354a85a3068e2e30fa098.jpg','channel'=>'84'),
  array('id'=>'1168','created_at'=>'2013-05-11 09:29:44','name'=>'Rogers Body Shop','website'=>'https://plus.google.com/100779245367700250452/about?gl=us&hl=en','logo_file'=>'e7672756be91dc17811ef03975614649b845e277.png','channel'=>'84'),
  array('id'=>'1169','created_at'=>'2013-05-11 09:35:58','name'=>'Crooners Lounge','website'=>'http://www.fslibertytheatre.com/#','logo_file'=>'bdb105a9f266fe398cab1b70a67c7adc93c5d7d3.png','channel'=>'84'),
  array('id'=>'1170','created_at'=>'2013-05-11 09:38:14','name'=>'Nevada Medical Clinic','website'=>'http://www.nevadamedicalclinic.com/','logo_file'=>'de1a9360d27c55bd99850223d5f43f6da1ece8bb.jpg','channel'=>'84'),
  array('id'=>'1171','created_at'=>'2013-05-11 09:40:06','name'=>'Nate\'s Place','website'=>'https://www.facebook.com/Nates.Place.LTM','logo_file'=>'6d62bcc02e2d3bb51c00fe00010bd5f98afbbff4.jpg','channel'=>'84'),
  array('id'=>'1172','created_at'=>'2013-05-15 17:01:44','name'=>'BUBBASAVESLIVES.org','website'=>'http://bubbasaveslives.org/','logo_file'=>'eb290e7dcf9b4c408d5fc87109003707e3439544.png','channel'=>'232'),
  array('id'=>'1173','created_at'=>'2013-05-15 20:23:53','name'=>'SPONSOR: J & J Construction','website'=>'http://www.RemodelCS.com','logo_file'=>'be079948c1139a9506cd74d1fa6685658cda770c.png','channel'=>'244'),
  array('id'=>'1175','created_at'=>'2013-05-17 12:13:05','name'=>'JCHC','website'=>'http://jchchealthcare.org/','logo_file'=>'835b895aa6b0ff2b321ecc342d0941103e82b8f7.jpg','channel'=>'251'),
  array('id'=>'1176','created_at'=>'2013-05-17 12:14:03','name'=>'H&R Block','website'=>'http://www.hrblock.com/','logo_file'=>'c2499bb72ca739fe08f57ac4daea18847a6b5e63.jpg','channel'=>'251'),
  array('id'=>'1177','created_at'=>'2013-05-17 12:14:28','name'=>'Fairbury Animal Clinic','website'=>'','logo_file'=>'694c6460da7661b6d2bfcbb52b9bc5d957dd8eaa.jpg','channel'=>'251'),
  array('id'=>'1178','created_at'=>'2013-05-17 12:15:43','name'=>'Crystal\'s Sale Barn Cafe','website'=>'','logo_file'=>'26af5aee2485019b61c141c23e6e1550d8a728bf.jpg','channel'=>'251'),
  array('id'=>'1179','created_at'=>'2013-05-17 12:16:00','name'=>'Chuckles','website'=>'','logo_file'=>'020d29ab52170f4ff4be4844ced620e3fcf04fad.jpg','channel'=>'251'),
  array('id'=>'1180','created_at'=>'2013-05-17 12:17:13','name'=>'C&O Ford','website'=>'http://co.dealerconnection.com/','logo_file'=>'945d7068d28e0e24d7b461b13b0b592af27eb2fd.jpg','channel'=>'251'),
  array('id'=>'1181','created_at'=>'2013-05-17 12:17:33','name'=>'Brandt\'s','website'=>'','logo_file'=>'c1518eb4be9568bec019b9d6dd5020a735c8fdbd.jpg','channel'=>'251'),
  array('id'=>'1182','created_at'=>'2013-05-17 12:18:46','name'=>'Botz Chiropractic','website'=>'http://www.jeffbotzdc.com/','logo_file'=>'71ada5aa2e79bb6a54057e46c95812a2f1129151.jpg','channel'=>'251'),
  array('id'=>'1183','created_at'=>'2013-05-17 12:19:38','name'=>'Big Jer\'s','website'=>'','logo_file'=>'c15af52f50508c93ba0554285129a6599c7f3802.jpg','channel'=>'251'),
  array('id'=>'1184','created_at'=>'2013-05-17 12:19:59','name'=>'Ace Hardware','website'=>'','logo_file'=>'99586ab4cddee795bae8704a43fdd7407140ec62.jpg','channel'=>'251'),
  array('id'=>'1185','created_at'=>'2013-05-17 12:42:24','name'=>'DVD','website'=>'','logo_file'=>'beb6284f1cea1fa50767ae19806853fcdfc31e89.jpg','channel'=>'150'),
  array('id'=>'1186','created_at'=>'2013-05-17 12:42:44','name'=>'Crowder College','website'=>'','logo_file'=>'694d2c673f9b1b4045dcb5952e0b7dc3aa9f7a42.jpg','channel'=>'150'),
  array('id'=>'1187','created_at'=>'2013-05-17 12:43:02','name'=>'Pro-Lube','website'=>'','logo_file'=>'0f956b4d9686751885a54d29a9267924d41af205.jpg','channel'=>'150'),
  array('id'=>'1188','created_at'=>'2013-05-17 12:43:24','name'=>'Josh Hughes - American Family Insurance','website'=>'','logo_file'=>'df943d0c1f4d430b650b1a7b15e126d90eb28973.jpg','channel'=>'150'),
  array('id'=>'1189','created_at'=>'2013-05-17 12:43:56','name'=>'Simple Simon\'s Pizza','website'=>'','logo_file'=>'f2a7aca4d6c4ec067b43dabaaf66d86f9e747546.jpg','channel'=>'150'),
  array('id'=>'1190','created_at'=>'2013-05-17 12:44:34','name'=>'Lost Creek Flea Market','website'=>'','logo_file'=>'24d50d8e3a099cdfe31e516ae05ab3c73faa460a.jpg','channel'=>'150'),
  array('id'=>'1191','created_at'=>'2013-05-17 12:44:57','name'=>'Workman\'s Mini Mart','website'=>'','logo_file'=>'cfd57d8fb232b5cdfebcc5f95da66e038f526ba3.jpg','channel'=>'150'),
  array('id'=>'1192','created_at'=>'2013-05-17 14:27:47','name'=>'Gill Insurance','website'=>'','logo_file'=>'d3ace64698b4f8d911e10f900d3f4a7d9329ff05.jpg','channel'=>'251'),
  array('id'=>'1193','created_at'=>'2013-05-17 14:37:21','name'=>'Choice Communications','website'=>'','logo_file'=>'21e4188934d0f109821f491b07d3d17122a7d713.jpg','channel'=>'251'),
  array('id'=>'1194','created_at'=>'2013-05-17 14:38:03','name'=>'Lily\'s Flowers','website'=>'','logo_file'=>'6ae25bfa6e1f3bcfd54f0be0646030a6ef37834e.jpg','channel'=>'251'),
  array('id'=>'1195','created_at'=>'2013-05-17 14:39:19','name'=>'M&D Auto ','website'=>'http://www.fairbury.com/pages/shopping/md-auto.html','logo_file'=>'caee7c6df89a56fcf68ebb42e1ee23dc6d0bd741.jpg','channel'=>'251'),
  array('id'=>'1196','created_at'=>'2013-05-17 14:40:37','name'=>'MSA','website'=>'http://msapromo.com/','logo_file'=>'bfea5978a537cc232e2f9d0e290a43db4c4cae41.jpg','channel'=>'251'),
  array('id'=>'1197','created_at'=>'2013-05-17 14:42:21','name'=>'McBattas','website'=>'http://mcbattasprinting.com/','logo_file'=>'7b43623e31c22771bce78d2ca652d8d47ca879ce.jpg','channel'=>'251'),
  array('id'=>'1198','created_at'=>'2013-05-17 14:44:43','name'=>'Ray\'s Apple Market','website'=>'http://www.raysapplemarkets.com/loc_fairbury.php5','logo_file'=>'b00e620212365345044588d8abf6f06ef9e5ff3d.jpg','channel'=>'251'),
  array('id'=>'1199','created_at'=>'2013-05-17 14:46:01','name'=>'Riverside','website'=>'http://www.riversidechev.com/','logo_file'=>'b6fc6696621e9b9a9251ed40bd03e08ba62bd8a9.jpg','channel'=>'251'),
  array('id'=>'1200','created_at'=>'2013-05-17 14:46:29','name'=>'Schroeder\'s Family Foods','website'=>'','logo_file'=>'ae394071d6262d23b4841d2033b572697ab65009.jpg','channel'=>'251'),
  array('id'=>'1201','created_at'=>'2013-05-17 14:47:23','name'=>'Schultis and Son','website'=>'http://www.schultis.com/','logo_file'=>'22745511bc7037eb0a5c123a1a43a374856728b4.jpg','channel'=>'251'),
  array('id'=>'1202','created_at'=>'2013-05-17 14:48:16','name'=>'Starr Buckow','website'=>'http://www.starrbuckow.com/','logo_file'=>'51434b8b3176ad9cd8d4b743c1ec2b5c1e30e358.jpg','channel'=>'251'),
  array('id'=>'1203','created_at'=>'2013-05-17 14:50:13','name'=>'M&H Paint','website'=>'https://www.facebook.com/pages/MH-Paint-Body/636440996383052','logo_file'=>'71ec106a4e68f38f0b09afb0dcc4fb585df945e4.jpg','channel'=>'251'),
  array('id'=>'1204','created_at'=>'2013-05-17 14:51:01','name'=>'T.O. Haas Tire','website'=>'http://www.tohaastire.com/','logo_file'=>'18eedcacf2796c77636eba2071214b49858d8067.jpg','channel'=>'251'),
  array('id'=>'1205','created_at'=>'2013-05-17 14:52:09','name'=>'Tatro Chiropractic ','website'=>'','logo_file'=>'a19f0cd23f8252f1ba55ee2e4459663e6e0bdb59.jpg','channel'=>'251'),
  array('id'=>'1206','created_at'=>'2013-05-17 14:53:25','name'=>'Wally\'s ','website'=>'https://www.facebook.com/pages/Wallys-Sports-Bar-Grill/280158553972','logo_file'=>'fb7ba5a625142ff0f5efc5b839a0c5c3da1945cd.jpg','channel'=>'251'),
  array('id'=>'1207','created_at'=>'2013-05-17 14:54:10','name'=>'Cobblestone','website'=>'http://www.staycobblestone.com/ne/fairbury/','logo_file'=>'ac5218f3f20cfea0dbe5932200a73e03c725ecd1.jpg','channel'=>'251'),
  array('id'=>'1208','created_at'=>'2013-05-17 14:57:03','name'=>'TAS Collision and Repair','website'=>'http://www.fairbury.com/pages/shopping/tas-auto.html','logo_file'=>'ae98a4bf0adf8bae13ad41ebab59c2e34c145447.jpg','channel'=>'251'),
  array('id'=>'1209','created_at'=>'2013-05-17 14:57:53','name'=>'Pizza Hut 1','website'=>'http://www.pizzahut.com/locations/nebraska/fairbury/007777','logo_file'=>'5b5b834c5bec01f7575c27e8459ccb7420c037da.jpg','channel'=>'251'),
  array('id'=>'1210','created_at'=>'2013-05-17 14:58:14','name'=>'Pizza Hut 2','website'=>'http://www.pizzahut.com/locations/nebraska/fairbury/007777','logo_file'=>'16b7f03e1bf51fc4132b0e145e3b70f684f342fc.jpg','channel'=>'251'),
  array('id'=>'1211','created_at'=>'2013-05-19 11:48:25','name'=>'Lady George','website'=>'http://www.ladygeorgeandthedragon.com/','logo_file'=>'8aa59642916d1444f143f23d68472cfc51e3143d.jpg','channel'=>'251'),
  array('id'=>'1212','created_at'=>'2013-05-21 05:43:44','name'=>'Trenton High School','website'=>'','logo_file'=>'462cc04abd701c763afed7f109af482fa47b54c8.jpg','channel'=>'87'),
  array('id'=>'1213','created_at'=>'2013-05-21 07:11:57','name'=>'B_Fly Photos and Design','website'=>'http://www.bflyphotosar.com','logo_file'=>'302d5b119a5b2667603039ed3a5df719838f1e5e.jpg','channel'=>'242'),
  array('id'=>'1214','created_at'=>'2013-05-21 10:01:22','name'=>'Cline Tours','website'=>'http://www.clinetours.com','logo_file'=>'d5dde62f34d95274b094a36c9ca4f6869e6e8139.png','channel'=>'165'),
  array('id'=>'1215','created_at'=>'2013-05-21 10:05:49','name'=>'Shack Up Inn','website'=>'http://www.shackupinn.com','logo_file'=>'153e27d978c46b1128e3a731d94645342bf3125f.jpg','channel'=>'165'),
  array('id'=>'1216','created_at'=>'2013-05-21 10:10:07','name'=>'Crowley\'s Ridge Technical Institute','website'=>'http://www.crti.tec.ar.us','logo_file'=>'38b19e6fd5fa4e9407369401776122535e1ed4cf.jpg','channel'=>'165'),
  array('id'=>'1217','created_at'=>'2013-05-21 12:23:49','name'=>'Phillips College','website'=>'http://www.pccua.edu','logo_file'=>'8e8b993d8290a91fd253844f42c40671d3b03403.jpg','channel'=>'165'),
  array('id'=>'1218','created_at'=>'2013-05-24 07:04:12','name'=>'Debra Thompson','website'=>'http://www.DLTCPA.com','logo_file'=>'26ef3741d4b2d7aee76b5a5eda0eff7416663819.jpg','channel'=>'242'),
  array('id'=>'1219','created_at'=>'2013-05-24 07:05:32','name'=>'Libby McGhee','website'=>'','logo_file'=>'62b10f51fd2ec17f06392315cbae1483f7df8a9a.jpg','channel'=>'242'),
  array('id'=>'1220','created_at'=>'2013-05-26 21:17:40','name'=>'Service Brothers Appliance Repair','website'=>'http://www.servicebrothers.com/','logo_file'=>'ff0b9941b6bf1c3aff56bc7edc2c326e7778c614.jpg','channel'=>'133'),
  array('id'=>'1221','created_at'=>'2013-05-27 21:32:47','name'=>'LFR','website'=>'http://www.localfitnessrepair.com/','logo_file'=>'c197a52ec1fc6b2ac69eeba593da33ca94538351.jpg','channel'=>'133'),
  array('id'=>'1222','created_at'=>'2013-05-30 13:54:24','name'=>'Auburn State Bank','website'=>'http://www.auburnstatebank.com','logo_file'=>'005a8e2d228a7fac730c99554474e4a46def096b.jpg','channel'=>'238'),
  array('id'=>'1223','created_at'=>'2013-05-30 14:46:48','name'=>'American Senior Communities','website'=>'http://ASCSeniorCare.com','logo_file'=>'a0e88e9c43fc0a3939a82d7b0681d23ee358b85c.jpg','channel'=>'196'),
  array('id'=>'1224','created_at'=>'2013-05-30 14:50:21','name'=>'Logsdons Restaurant','website'=>'https://www.facebook.com/pages/Logsdons-Restaurant/123753807660050','logo_file'=>'51e66624c23f61ae07e88d70a3d08fd2d1407b1c.jpg','channel'=>'196'),
  array('id'=>'1225','created_at'=>'2013-05-30 14:54:10','name'=>'Freedom Medical','website'=>'http://www.freedommedical.biz/','logo_file'=>'08e21f55cd7832163cd71fa40dad4d02f387f01d.jpg','channel'=>'196'),
  array('id'=>'1226','created_at'=>'2013-05-31 08:50:11','name'=>'Ski Broncs Waterski Show Team','website'=>'http://www.skibroncs.com/','logo_file'=>'4aa17ae76929867e78246bc7071bc737b63ba35d.jpg','channel'=>'212'),
  array('id'=>'1227','created_at'=>'2013-05-31 12:26:08','name'=>'D Patrick Boonville','website'=>'http://boonvilleford.dpat.com','logo_file'=>'a0db71e611b9a13b7ae38e95df597b4da353e780.jpg','channel'=>'196'),
  array('id'=>'1229','created_at'=>'2013-05-31 12:54:15','name'=>'Becca\'s Restaurant','website'=>'','logo_file'=>'2ac19e055ddb4a3357fa7a77ea0a3e41d10e46c5.jpg','channel'=>'196'),
  array('id'=>'1230','created_at'=>'2013-05-31 21:31:12','name'=>'r7s','website'=>'http://www.randsconstruction.org','logo_file'=>'4cf9d58b69d168dbb88a361e0dc984711d2a6b36.jpg','channel'=>'242'),
  array('id'=>'1231','created_at'=>'2013-06-01 18:24:57','name'=>'ManasotaTV','website'=>'http://www.citylinktv.com/sarasota-manasota-tv','logo_file'=>'808b5cbf531464b54a2fbbad90482a15695a4c8e.jpg','channel'=>'232'),
  array('id'=>'1232','created_at'=>'2013-06-02 22:14:51','name'=>'Send Out Cards','website'=>'http://www.socgratitude.com/119844','logo_file'=>'5cf7706bf50dd9342bd4bcad658484328a741a6e.jpg','channel'=>'212'),
  array('id'=>'1233','created_at'=>'2013-06-02 22:15:34','name'=>'Is Your God Real?','website'=>'http://fb.me/1u8Vhj6xI','logo_file'=>'b04eee40877072f30599de5034ac28eb8cae826d.jpg','channel'=>'212'),
  array('id'=>'1234','created_at'=>'2013-06-02 22:18:06','name'=>'THOR Advertising','website'=>'http://www.linkedin.com/in/ascensionproservices/','logo_file'=>'c4fd628431e62906f864b6ccc28aff7659050256.jpg','channel'=>'212'),
  array('id'=>'1235','created_at'=>'2013-06-03 06:48:53','name'=>'Charlotte TV','website'=>'http://www.citylinktv.com/charlotte','logo_file'=>'30e8b262b838796e10fb719101f3ad44e6ba3e7d.jpg','channel'=>'257'),
  array('id'=>'1243','created_at'=>'2013-06-03 13:36:16','name'=>'SMG-TV','website'=>'','logo_file'=>'703ee53d3bb071d609d93b30c23c5b9b518ab576.jpg','channel'=>'45'),
  array('id'=>'1244','created_at'=>'2013-06-03 13:36:34','name'=>'Workman\'s Mini Mart','website'=>'','logo_file'=>'ae8c4f0a8192cdb0bc57a83cd5778d00b4b7cec5.jpg','channel'=>'45'),
  array('id'=>'1245','created_at'=>'2013-06-03 13:36:51','name'=>'DVDs available','website'=>'','logo_file'=>'c15ef42c4255f6ba491de61dacb01c55748ada85.jpg','channel'=>'45'),
  array('id'=>'1246','created_at'=>'2013-06-03 13:37:06','name'=>'Pro-Lube','website'=>'','logo_file'=>'f4289f9749bdd7a7293be3145f39f941a32d6f1c.jpg','channel'=>'45'),
  array('id'=>'1247','created_at'=>'2013-06-03 13:37:27','name'=>'Josh Hughes - American Family Insurance','website'=>'','logo_file'=>'612402e8b688ef97cf32043de3a81f4d76c059bc.jpg','channel'=>'45'),
  array('id'=>'1248','created_at'=>'2013-06-03 13:37:44','name'=>'Crowder College','website'=>'','logo_file'=>'15a105ffe2f17a33bf1a094902fd18f051df8891.jpg','channel'=>'45'),
  array('id'=>'1249','created_at'=>'2013-06-04 19:13:28','name'=>'Twitter','website'=>'https://twitter.com/WHBTV','logo_file'=>'9b9433d5e6748f50e0d21d077e9cbd1da88cf86f.jpg','channel'=>'195'),
  array('id'=>'1250','created_at'=>'2013-06-04 19:14:46','name'=>'facebookj','website'=>'https://www.facebook.com/810WhbTv','logo_file'=>'e9892eaf80f421256ea64f19fbfd619bd16c0b37.jpg','channel'=>'195')
);
*/




foreach($sponsors as $sponsor) {
	//if there's a legacy channel
	if($sponsor['channel']) {
	
		//make sure sponsor doesn't already exist
		$insert = true;
		$old_sponsor = new WP_Query(array('post_type'=>'sponsor', 'meta_key'=>'legacy_sponsor', 'meta_value'=>$sponsor['id']));
		if($old_sponsor->have_posts()) $insert = false;
		wp_reset_postdata();
		
		//definitely inserting
		if($insert){
		
			//get the attached channel
			$channel_q = new WP_Query(array('post_type'=>'channel', 'meta_key'=>'legacy_channel', 'meta_value'=>$sponsor['channel']));
			if($channel_q->found_posts == 1) {	
				
				// set arguments for sponsor	
				$channel = $channel_q->posts[0];	
				$args = array(
					'post_author' => $channel->post_author ,
					'post_title' => $sponsor['name'],
					'post_type' => 'sponsor',
					'post_status' => 'publish'
				);			
				
				//update/insert
				$post_id = wp_insert_post($args);	
					
				//if update/insert was successful
				if($post_id) {			
					//add meta values
					add_post_meta($post_id, 'legacy_sponsor', $sponsor['id']); 
					add_post_meta($post_id, 'sponsor_url', $sponsor['website']); 
					add_post_meta($post_id, 'channel', $channel->ID); 
					
					//insert the thumbnail
					$filename = $sponsor['logo_file'];
					
					$wp_filetype = wp_check_filetype(basename($filename), null );
					$attachment = array(
						'guid' => 'http://www.citylinktv.com/uploads/sponsor' . '/' . basename( $filename ), 
						'post_mime_type' => $wp_filetype['type'],
						'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
						'post_content' => '',
						'post_status' => 'inherit'
					);					
					$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
					wp_update_attachment_metadata( $attach_id, $attach_data );				
					update_post_meta( $post_id,'_thumbnail_id',$attach_id);
				} 
			} 
			wp_reset_postdata();
		}
	}
}