CREATE TABLE inputParams (
  radius DECIMAL(18, 4) CHECK (radius > 0),
  hour   INT CHECK (hour >= 0),
  pLat   DECIMAL(8, 6) -- x value of P
    CHECK (pLat BETWEEN -90.0 AND 90.0),
  pLong  DECIMAL(9, 6) -- y value of P
    CHECK (pLong BETWEEN -180.0 AND 180.0),
);
GO

1.60934 * 2 * 3961 * asin(sqrt((sin(radians((input.pLat - Details.latitude) / 2))) ^ 2 + cos(radians(Details.latitude)) * cos(radians(input.pLat)) * (sin(radians((input.pLong - Details.longtitude) / 2))) ^ 2)) as distance
CREATE VIEW HeatMap AS
  SELECT count(driverID) --to identify hotspots, we count each
  FROM DriveDetails Details, inputParams input -- cross with input that has 1 row
  WHERE (abs(Details.latitude - input.pLat) <= input.radius)--distance from lat,long to px,py is smaller than r
        AND (abs(Details.longtitude - input.pLong) <= input.radius)
        AND (datepart(HOUR, Details.timestamp) = input.hour); --timestamp's hour is h
