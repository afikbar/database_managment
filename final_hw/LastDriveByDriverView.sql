CREATE VIEW LastDriveByDriver AS
  SELECT
    driverID,
    Details.passenger,
    Details.gps,
    Details.timestamp
  FROM DriveDetails Details
  WHERE timestamp = (SELECT max(timestamp)
                     FROM DriveDetails d2
                     WHERE d2.driverID = Details.driverID);