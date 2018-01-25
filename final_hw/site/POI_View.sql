CREATE VIEW POI_NYC AS
  SELECT
    cp.Hour,
    cp.CentralPark,
    TimesSquare,
    EmpireStatesBLD,
    Chinatown
  FROM (SELECT
          count(s.Ctime)          AS CentralPark,
          datepart(HOUR, s.Ctime) AS Hour
        FROM small_drive s
        WHERE (1.60934 * 2 * 3961 * asin(sqrt(POWER((sin(radians((s.location_lat - 40.782800) / 2))), 2) +
                                              cos(radians(40.782800)) * cos(radians(s.location_lat)) *
                                              POWER((sin(radians((s.location_long + 73.965441) / 2))), 2)))) < 0.5
        GROUP BY datepart(HOUR, s.Ctime)) cp,
    (SELECT
       count(s.Ctime)          AS TimesSquare,
       datepart(HOUR, s.Ctime) AS Hour
     FROM small_drive s
     WHERE (1.60934 * 2 * 3961 * asin(sqrt(POWER((sin(radians((s.location_lat - 40.758897) / 2))), 2) +
                                           cos(radians(40.758897)) * cos(radians(s.location_lat)) *
                                           POWER((sin(radians((s.location_long + 73.985126) / 2))), 2)))) < 0.5
     GROUP BY datepart(HOUR, s.Ctime)) ts,
    (SELECT
       count(s.Ctime)          AS EmpireStatesBLD,
       datepart(HOUR, s.Ctime) AS Hour
     FROM small_drive s
     WHERE
       (1.60934 * 2 * 3961 * asin(sqrt(POWER((sin(radians((s.location_lat - 40.748538) / 2))), 2) +
                                       cos(radians(40.748538)) * cos(radians(s.location_lat)) *
                                       POWER((sin(radians((s.location_long + 73.985664) / 2))), 2)))) < 0.5
     GROUP BY datepart(HOUR, s.Ctime)) esb,
    (SELECT
       count(s.Ctime)          AS Chinatown,
       datepart(HOUR, s.Ctime) AS Hour
     FROM small_drive s
     WHERE (1.60934 * 2 * 3961 * asin(sqrt(POWER((sin(radians((s.location_lat - 40.715854) / 2))), 2) +
                                           cos(radians(40.715854)) * cos(radians(s.location_lat)) *
                                           POWER((sin(radians((s.location_long + 73.997181) / 2))), 2)))) < 0.5
     GROUP BY datepart(HOUR, s.Ctime)) cht
  WHERE cp.Hour = ts.Hour AND ts.Hour = esb.Hour AND esb.Hour = cht.Hour;


