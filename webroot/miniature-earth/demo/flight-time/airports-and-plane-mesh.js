// var airports = [
// 	['ARN','Stockholm, Sweden',59.651901245117,17.918600082397],
// 	['BKK','Bangkok, Thailand',13.681099891662598,100.74700164794922],
// 	['CAI','Cairo, Egypt',30.12190055847168,31.40559959411621],
// 	['CGK','Jakarta, Indonesia',-6.1255698204,106.65599823],
// 	['CMB','Colombo, Sri Lanka',7.180759906768799,79.88410186767578],
// 	['CPT','Cape Town, South Africa',-33.9648017883,18.6016998291],
// 	['CUR','Curaçao, Netherlands',12.1889,-68.959801],
// 	['DEL','Delhi, India',28.566499710083008,77.10310363769531],
// 	['DXB','Dubai, UAE',25.2527999878,55.3643989563],
// 	['EZE','Buenos Aires, Argentina',-34.8222,-58.5358],
// 	['FCO','Rome, Italy',41.8002778,12.2388889],
// 	['HKG','Hong Kong',22.3089008331,113.915000916],
// 	['HND','Tokyo, Japan',35.552299,139.779999],
// 	['HNL','Hawaii, USA',21.318700790405273,-157.9219970703125],
// 	['JFK','New York, USA',40.63980103,-73.77890015],
// 	['KEF','Keflavik, Iceland',63.985000610352,-22.605600357056],
// 	['LAX','Los Angeles, USA',33.94250107,-118.4079971],
// 	['LIM','Lima, Peru',-12.0219,-77.114304],
// 	['LHR','London, UK',51.4706,-0.461941],
// 	['LPA','Gran Canaria, Spain',27.931900024414062,-15.38659954071045],
// 	['MAD','Madrid, Spain',40.471926,-3.56264],
// 	['MEX','Mexico',19.4363,-99.072098],
// 	['MIA','Miami, USA',25.79319953918457,-80.29060363769531],
// 	['NBO','Nairobi, Kenya',-1.31923997402,36.9277992249],
// 	['ORD','Chicago, USA',41.97859955,-87.90480042],
// 	['PEK','Beijing, China',40.080101013183594,116.58499908447266],
// 	['PVG','Shanghai, China',31.143400192260742,121.80500030517578],
// 	['SIN','Singapore',1.35019,103.994003],
// 	['SYD','Sydney, Australia',-33.94609832763672,151.177001953125],
// 	['SCL','Santiago, Chile',-33.393001556396484,-70.78579711914062],
// 	['SDU','Rio de Janeiro, Brazil',-22.910499572799996,-43.1631011963],
// 	['VKO','Moscow, Russia',55.5914993286,37.2615013123],
// 	['WLG','Wellington, New Zealand',-41.3272018433,174.804992676],
// 	['YVR','Vancouver, Canada',49.193901062,-123.183998108],
// ];

var airplaneMesh = 'o plane\nv 0.376 0.008 -0.044\nv 0.257 0.150 -0.044\nv 0.256 0.079 -0.091\nv 0.196 0.033 -0.079\nv 0.262 0.010 -0.044\nv 0.148 0.008 -0.059\nv 0.254 0.120 -0.078\nv 0.381 0.037 -0.075\nv 0.385 0.076 -0.086\nv 0.393 0.144 -0.043\nv 0.392 0.116 -0.074\nv 0.501 0.013 -0.025\nv 0.480 0.068 -0.069\nv 0.483 0.035 -0.057\nv 0.545 0.060 -0.047\nv 0.562 0.084 -0.039\nv -0.237 0.122 -0.071\nv -0.245 0.145 -0.044\nv -0.189 0.080 -0.087\nv -0.182 0.039 -0.077\nv -0.191 0.016 -0.044\nv -0.356 0.150 -0.039\nv -0.389 0.057 -0.063\nv -0.385 0.035 -0.037\nv -0.451 0.160 -0.021\nv -0.502 0.105 -0.056\nv -0.471 0.093 -0.067\nv -0.500 0.071 -0.048\nv -0.500 0.053 -0.028\nv -0.577 0.104 -0.033\nv -0.600 0.091 -0.046\nv 0.481 0.098 -0.059\nv 0.498 0.124 -0.035\nv 0.127 0.067 -0.087\nv -0.184 0.079 -0.314\nv -0.126 0.051 -0.084\nv -0.221 0.114 -0.672\nv 0.119 0.025 -0.083\nv -0.296 0.114 -0.664\nv -0.184 0.073 -0.315\nv -0.117 0.036 -0.083\nv -0.103 0.016 -0.068\nv 0.135 0.047 -0.085\nv -0.636 0.115 -0.233\nv -0.677 0.115 -0.226\nv 0.376 0.008 0.044\nv 0.311 0.161 0.000\nv 0.257 0.150 0.044\nv 0.256 0.079 0.091\nv 0.196 0.033 0.079\nv 0.262 0.010 0.044\nv 0.148 0.008 0.059\nv 0.254 0.120 0.078\nv 0.381 0.037 0.075\nv 0.385 0.076 0.086\nv 0.393 0.144 0.043\nv 0.454 0.155 0.000\nv 0.392 0.116 0.074\nv 0.501 0.013 0.025\nv 0.507 0.005 0.000\nv 0.480 0.068 0.069\nv 0.536 0.132 0.000\nv 0.595 0.018 0.000\nv 0.483 0.035 0.057\nv 0.545 0.060 0.047\nv 0.562 0.084 0.039\nv 0.628 0.045 0.000\nv -0.237 0.122 0.071\nv -0.232 0.157 0.000\nv -0.245 0.145 0.044\nv -0.189 0.080 0.087\nv -0.182 0.039 0.077\nv -0.191 0.016 0.044\nv -0.356 0.150 0.039\nv -0.389 0.057 0.063\nv -0.385 0.035 0.037\nv -0.451 0.160 0.021\nv -0.502 0.105 0.056\nv -0.471 0.093 0.067\nv -0.301 0.020 0.000\nv -0.500 0.071 0.048\nv -0.500 0.053 0.028\nv -0.584 0.130 0.000\nv -0.577 0.104 0.033\nv -0.438 0.046 0.000\nv -0.608 0.110 0.000\nv -0.600 0.091 0.046\nv -0.538 0.081 0.000\nv 0.481 0.098 0.059\nv 0.498 0.124 0.035\nv 0.593 0.093 0.000\nv -0.357 0.185 0.000\nv -0.280 0.157 0.000\nv 0.127 0.067 0.087\nv -0.184 0.079 0.314\nv -0.126 0.051 0.084\nv -0.221 0.114 0.672\nv 0.119 0.025 0.083\nv -0.296 0.114 0.664\nv -0.184 0.073 0.315\nv -0.117 0.036 0.083\nv -0.103 0.016 0.068\nv 0.135 0.047 0.085\nv -0.043 0.004 0.000\nv 0.294 0.001 0.000\nv -0.636 0.115 0.233\nv -0.677 0.115 0.226\nv -0.529 0.319 -0.007\nv -0.573 0.312 0.000\nv -0.498 0.326 0.000\nv -0.529 0.319 0.007\nvn 0.00 1.00 0.00\nvn -0.02 0.81 -0.58\nvn 0.03 0.99 0.00\nvn 0.97 -0.22 0.00\nvn 0.47 0.38 -0.79\nvn 0.70 0.70 0.00\nvn 0.54 -0.84 0.00\nvn 0.18 -0.84 -0.50\nvn 0.20 -0.55 -0.80\nvn 0.36 -0.20 -0.90\nvn 0.26 0.41 -0.87\nvn 0.24 -0.01 -0.96\nvn 0.27 0.73 -0.62\nvn 0.12 0.51 -0.84\nvn 0.09 0.85 -0.51\nvn 0.47 0.88 0.00\nvn 0.21 0.97 0.00\nvn 0.07 -0.52 -0.84\nvn 0.10 -0.00 -0.99\nvn 0.03 -0.90 -0.43\nvn 0.11 -0.99 0.00\nvn 0.00 0.88 -0.46\nvn -0.13 0.68 -0.71\nvn -0.13 0.68 0.71\nvn 0.50 0.86 0.00\nvn 0.05 -0.51 -0.85\nvn 0.04 -0.91 -0.39\nvn 0.20 -0.75 -0.61\nvn -0.02 -0.99 0.00\nvn 0.00 -1.00 0.00\nvn 0.03 -0.90 -0.41\nvn 0.04 0.10 -0.99\nvn 0.26 0.34 -0.89\nvn 0.38 -0.13 -0.91\nvn -0.68 0.67 0.26\nvn -0.39 0.03 -0.91\nvn -0.70 0.08 -0.70\nvn -0.70 -0.70 0.10\nvn -0.25 -0.77 -0.58\nvn -0.05 -0.85 -0.50\nvn 0.00 0.02 -0.99\nvn -0.03 0.06 -0.99\nvn -0.11 -0.54 -0.83\nvn -0.09 -0.93 -0.33\nvn 0.00 0.53 -0.84\nvn 0.00 0.88 -0.46\nvn 0.02 0.99 0.00\nvn -0.02 0.54 -0.83\nvn -0.10 -0.99 0.00\nvn -0.15 -0.92 -0.33\nvn -0.12 -0.56 -0.81\nvn -0.91 -0.36 -0.19\nvn -0.00 0.10 0.99\nvn -0.78 0.06 0.61\nvn -0.00 0.87 -0.48\nvn -0.03 0.40 -0.91\nvn 0.04 0.05 -0.99\nvn -0.28 0.90 -0.31\nvn -0.56 0.82 0.00\nvn -0.17 -0.85 -0.49\nvn -0.34 -0.93 0.00\nvn -0.91 -0.36 0.19\nvn -0.44 -0.87 -0.17\nvn -0.17 -0.98 0.00\nvn -0.99 0.07 0.00\nvn 0.42 0.90 0.00\nvn -0.28 0.90 0.31\nvn -0.00 0.10 -0.99\nvn -0.78 0.06 -0.61\nvn -0.02 0.81 0.58\nvn 0.47 0.38 0.79\nvn 0.18 -0.84 0.50\nvn 0.36 -0.20 0.90\nvn 0.20 -0.55 0.80\nvn 0.26 0.41 0.87\nvn 0.24 -0.01 0.96\nvn 0.27 0.73 0.62\nvn 0.09 0.85 0.51\nvn 0.12 0.51 0.84\nvn 0.10 -0.00 0.99\nvn 0.07 -0.52 0.84\nvn 0.03 -0.90 0.43\nvn 0.00 0.88 0.46\nvn 0.05 -0.51 0.85\nvn 0.20 -0.75 0.61\nvn 0.04 -0.91 0.39\nvn 0.03 -0.90 0.41\nvn 0.04 0.10 0.99\nvn 0.38 -0.13 0.91\nvn 0.26 0.34 0.89\nvn -0.39 0.03 0.91\nvn -0.68 0.67 -0.26\nvn -0.70 0.08 0.70\nvn -0.25 -0.77 0.58\nvn -0.70 -0.70 -0.10\nvn -0.05 -0.85 0.50\nvn 0.00 0.02 0.99\nvn -0.03 0.06 0.99\nvn -0.11 -0.54 0.83\nvn -0.09 -0.93 0.33\nvn 0.00 0.88 0.46\nvn 0.00 0.53 0.84\nvn -0.02 0.54 0.83\nvn -0.15 -0.92 0.33\nvn -0.12 -0.56 0.81\nvn -0.03 0.40 0.91\nvn -0.00 0.87 0.48\nvn 0.04 0.05 0.99\nvn -0.17 -0.85 0.49\nvn -0.44 -0.87 0.17\nvn -0.87 0.47 0.00\ns 1\nf 69//1 22//2 93//3\nf 67//4 16//5 91//6\nf 67//4 63//7 12//8\nf 67//4 14//9 15//10\nf 16//5 15//10 32//11\nf 15//10 13//12 32//11\nf 32//11 33//13 16//5\nf 15//10 14//9 13//12\nf 33//13 11//14 10//15\nf 62//16 10//15 57//17\nf 32//11 13//12 11//14\nf 13//12 8//18 9//19\nf 14//9 1//20 8//18\nf 12//8 60//21 1//20\nf 69//1 18//22 22//2\nf 108//23 111//24 110//25\nf 4//26 6//27 38//28\nf 104//29 6//27 105//30\nf 5//31 105//30 6//27\nf 37//32 34//33 43//34\nf 37//32 43//34 38//28\nf 43//34 4//26 38//28\nf 43//34 34//33 4//26\nf 4//26 5//31 6//27\nf 34//33 35//35 36//36\nf 37//32 35//35 34//33\nf 35//35 37//32 39//37\nf 36//36 40//38 41//39\nf 35//35 39//37 40//38\nf 39//37 37//32 40//38\nf 37//32 38//28 40//38\nf 40//38 38//28 41//39\nf 42//40 38//28 6//27\nf 3//41 4//26 34//33\nf 19//42 34//33 36//36\nf 20//43 42//40 21//44\nf 41//39 42//40 20//43\nf 1//20 105//30 5//31\nf 10//15 7//45 2//46\nf 11//14 3//41 7//45\nf 9//19 4//26 3//41\nf 8//18 5//31 4//26\nf 2//46 69//1 47//47\nf 34//33 17//48 7//45\nf 17//48 18//22 2//46\nf 36//36 41//39 20//43\nf 38//28 42//40 41//39\nf 104//29 21//44 42//40\nf 36//36 20//43 19//42\nf 21//44 80//49 24//50\nf 20//43 24//50 23//51\nf 18//22 17//48 22//2\nf 2//46 57//17 10//15\nf 87//52 106//53 107//54\nf 22//2 26//55 25//56\nf 17//48 27//57 26//55\nf 19//42 23//51 27//57\nf 25//56 30//58 83//59\nf 28//60 88//61 31//62\nf 23//51 29//63 28//60\nf 24//50 85//64 29//63\nf 29//63 85//64 88//61\nf 30//58 31//62 86//65\nf 83//59 30//58 86//65\nf 31//62 88//61 86//65\nf 16//5 67//4 15//10\nf 12//8 14//9 67//4\nf 16//5 33//13 91//6\nf 62//16 91//6 33//13\nf 12//8 63//7 60//21\nf 33//13 32//11 11//14\nf 62//16 33//13 10//15\nf 11//14 13//12 9//19\nf 13//12 14//9 8//18\nf 14//9 12//8 1//20\nf 93//3 22//2 25//56\nf 93//3 25//56 92//66\nf 104//29 42//40 6//27\nf 106//53 84//67 107//54\nf 36//36 35//35 40//38\nf 1//20 60//21 105//30\nf 10//15 11//14 7//45\nf 11//14 9//19 3//41\nf 9//19 8//18 4//26\nf 8//18 1//20 5//31\nf 3//41 34//33 7//45\nf 2//46 18//22 69//1\nf 7//45 17//48 2//46\nf 34//33 19//42 17//48\nf 104//29 80//49 21//44\nf 20//43 21//44 24//50\nf 19//42 20//43 23//51\nf 2//46 47//47 57//17\nf 22//2 17//48 26//55\nf 17//48 19//42 27//57\nf 25//56 26//55 30//58\nf 44//68 30//58 26//55\nf 27//57 23//51 28//60\nf 27//57 44//68 26//55\nf 28//60 29//63 88//61\nf 23//51 24//50 29//63\nf 24//50 80//49 85//64\nf 27//57 28//60 44//68\nf 30//58 45//69 31//62\nf 69//1 93//3 74//70\nf 67//4 91//6 66//71\nf 67//4 59//72 63//7\nf 67//4 65//73 64//74\nf 66//71 89//75 65//73\nf 65//73 89//75 61//76\nf 89//75 66//71 90//77\nf 65//73 61//76 64//74\nf 90//77 56//78 58//79\nf 62//16 57//17 56//78\nf 89//75 58//79 61//76\nf 61//76 55//80 54//81\nf 64//74 54//81 46//82\nf 59//72 46//82 60//21\nf 69//1 74//70 70//83\nf 25//56 110//25 92//66\nf 50//84 98//85 52//86\nf 104//29 105//30 52//86\nf 51//87 52//86 105//30\nf 97//88 103//89 94//90\nf 97//88 98//85 103//89\nf 103//89 98//85 50//84\nf 103//89 50//84 94//90\nf 50//84 52//86 51//87\nf 94//90 96//91 95//92\nf 97//88 94//90 95//92\nf 95//92 99//93 97//88\nf 96//91 101//94 100//95\nf 95//92 100//95 99//93\nf 99//93 100//95 97//88\nf 97//88 100//95 98//85\nf 100//95 101//94 98//85\nf 102//96 52//86 98//85\nf 49//97 94//90 50//84\nf 71//98 96//91 94//90\nf 72//99 73//100 102//96\nf 101//94 72//99 102//96\nf 46//82 51//87 105//30\nf 56//78 48//101 53//102\nf 58//79 53//102 49//97\nf 55//80 49//97 50//84\nf 54//81 50//84 51//87\nf 48//101 47//47 69//1\nf 94//90 53//102 68//103\nf 68//103 48//101 70//83\nf 96//91 72//99 101//94\nf 98//85 101//94 102//96\nf 104//29 102//96 73//100\nf 96//91 71//98 72//99\nf 73//100 76//104 80//49\nf 72//99 75//105 76//104\nf 70//83 74//70 68//103\nf 48//101 56//78 57//17\nf 44//68 45//69 30//58\nf 74//70 77//106 78//107\nf 68//103 78//107 79//108\nf 71//98 79//108 75//105\nf 77//106 83//59 84//67\nf 81//109 87//52 88//61\nf 75//105 81//109 82//110\nf 76//104 82//110 85//64\nf 82//110 88//61 85//64\nf 84//67 86//65 87//52\nf 83//59 86//65 84//67\nf 87//52 86//65 88//61\nf 66//71 65//73 67//4\nf 59//72 67//4 64//74\nf 66//71 91//6 90//77\nf 62//16 90//77 91//6\nf 59//72 60//21 63//7\nf 90//77 58//79 89//75\nf 62//16 56//78 90//77\nf 58//79 55//80 61//76\nf 61//76 54//81 64//74\nf 64//74 46//82 59//72\nf 93//3 77//106 74//70\nf 93//3 92//66 77//106\nf 104//29 52//86 102//96\nf 31//62 44//68 28//60\nf 96//91 100//95 95//92\nf 46//82 105//30 60//21\nf 56//78 53//102 58//79\nf 58//79 49//97 55//80\nf 55//80 50//84 54//81\nf 54//81 51//87 46//82\nf 49//97 53//102 94//90\nf 48//101 69//1 70//83\nf 53//102 48//101 68//103\nf 94//90 68//103 71//98\nf 104//29 73//100 80//49\nf 72//99 76//104 73//100\nf 71//98 75//105 72//99\nf 48//101 57//17 47//47\nf 74//70 78//107 68//103\nf 68//103 79//108 71//98\nf 77//106 84//67 78//107\nf 106//53 78//107 84//67\nf 79//108 81//109 75//105\nf 79//108 78//107 106//53\nf 81//109 88//61 82//110\nf 75//105 82//110 76//104\nf 76//104 85//64 80//49\nf 79//108 106//53 81//109\nf 84//67 87//52 107//54\nf 83//59 108//23 25//56\nf 77//106 110//25 111//24\nf 83//59 111//24 109//111\nf 108//23 109//111 111//24\nf 87//52 81//109 106//53\nf 25//56 108//23 110//25\nf 31//62 45//69 44//68\nf 83//59 109//111 108//23\nf 77//106 92//66 110//25\nf 83//59 77//106 111//24\n';
