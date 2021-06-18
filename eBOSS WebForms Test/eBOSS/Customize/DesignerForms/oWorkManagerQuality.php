<?php


class oWorkManagerQuality
{
    const Section = 'WorkManagerQuality';
    const _Language = self::Section . '.Language';
    const _ServerName = self::Section.'.SeverName';
    const _UserName = self::Section.'.UserName';
    const _Password = self::Section.'.Password';
    const _DatabaseName = self::Section.'.DatabaseName';
    const _Barcode = self::Section.'.BarcodeScanner';
    const _CurrentBarcode = self::Section . '_CurrentBarcode';
    const _CurrentEmployeeAID = self::Section . '.CurrentEmployeeAID';

    const _CurrentIsShowNg = self::Section . '.IsShowNg';
    const _CurrentIsOK = self::Section . '.IsOK';
    const _CurrentErrorID = self::Section . '.ErrorID';
    const _CurrentErrorPositionID = self::Section . '.ErrorSectionID';

    const _CurrentIsSaveError = self::Section . '.IsSaveError';
    const _CurrentIsRefreshError = self::Section . '.IsRefreshError';

    const tbQualityInput = 'dbo.tblQualityControlInput';
    const coReportItemAID = 'ReportItemAID';
    const coCommandAID = 'CommandAID';
    const coCheckDate = 'CheckDate';
    const coWorkShiftID = 'WorkShiftID';
    const coMachineID = 'MachineID';
    const coProductAID = 'ProductAID';
    const coCheckVersionNo = 'CheckVersionNo';
    const coEmployeeCheck01AID = 'EmployeeCheck01AID';
    const coEmployeeCheck02AID = 'EmployeeCheck02AID';
    const coStartDateTime = 'StartDateTime';
    const coEndDateTime = 'EndDateTime';
    const coEmployeeQuickRepairAID = 'EmployeeQuickRepairAID';
    const coIsReturnRepair = 'IsReturnRepair';
    const coCheckResultID = 'CheckResultID';
    const coCheckOperationID = 'CheckOperationID';

    const tbQualityInputNG = 'dbo.tblQualityControlInputNG';
    const coNgItemAID = 'NgItemAID';
    const coCheckErrorID = 'CheckErrorID';
    const coCheckErrorPositionID = 'CheckErrorPositionID';
    const coCiritLoop01ID = 'CiritLoop01ID';
    const coCiritLoop02ID = 'CiritLoop02ID';
    const coCiritLoop03ID = 'CiritLoop03ID';
    const coCiritLoop04ID = 'CiritLoop04ID';
    const coCiritLoop05ID = 'CiritLoop05ID';
    const coCiritLoop06ID = 'CiritLoop06ID';
    const coCiritLoop07ID = 'CiritLoop07ID';
    const coCiritLoop08ID = 'CiritLoop08ID';
    const coCommandID = 'CommandID';
    const coCheckSerialNo = 'CheckSerialNo';
    const coResultName = 'ResultName';
    const coOperationName = 'OperationName';
    const coTotalTime = 'TotalTime';
    const coErrorName = 'ErrorName';
    const coErrorPositionName = 'ErrorPositionName';
    const coIsFinish = 'IsFinish';
    const coIsCheckNo2 = 'IsCheckNo2';
    const coProductName = 'ProductName';


    const scBarcodeQualityResult = "SELECT * FROM dbo.GetWebBarcodeScannerQualityResult('@BarcodeValue')";
    const scQualityInput = "SELECT * FROM dbo.tblQualityControlInput WHERE ReportItemAID = '@ReportItemAID'";

    const scGetQualityInputResult = "SELECT * FROM dbo.GetWebQualityInputResult('@CommandAID', '@VersionNo', '@Language')";

    const scQualityInputNG = "SELECT * FROM dbo.tblQualityControlInputNG WHERE ReportItemAID = '@ReportItemAID'";

    const scBasQualityError = "SELECT dbo.fSwitchLang('@Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS ErrorName FROM dbo.tblBasQualityControlErrorSetting WHERE ErrorID = '@ErrorID'";
    const scBasQualityErrorPosition = "SELECT dbo.fSwitchLang('@Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS ErrorPositionName FROM dbo.tblBasQualityControlErrorPositionSetting WHERE ErrorPositionID = '@ErrorPositionID'";

    const scEmployeeCheck = "SELECT        Info.ObjectAID AS EmployeeAID, Info.ObjectID AS EmployeeID, dbo.fSwitchLang('@Language', Info.NameChinese, Info.NameVietnamese, Info.NameEnglish, Info.NameOther) AS EmployeeName
                                FROM            dbo.tblBasObjectInfo AS Info INNER JOIN
                                                         dbo.tblBasObjectGroup AS ObjectGroup ON Info.GroupID = ObjectGroup.GroupID
                                WHERE        (ObjectGroup.GroupRefID = dbo.GetBasObjectGroupRefEmployeeID()) AND (Info.ObjectID = '@EmployeeID')";

    const scProductInfo = "SELECT dbo.fSwitchLang('@Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS ProductName FROM dbo.tblBasProductInfo WHERE ProductAID = '@ProductAID'";


    const scBarcodeStatus = "SELECT        TOP (1) CommandAID, IsCheckNo2, CheckResultID, IsFinish
                            FROM            dbo.tblQualityControlInput
                            WHERE        (CommandAID = '@CommandAID') AND (CheckVersionNo = '@VersionNo')
                            ORDER BY CheckDate, EndDateTime DESC";

    const _CurrentStartDateTimeNow = self::Section . '.StartDateTimeNow';
    const _CurrentRecordTimeNow = self::Section . '.CurrentRecordTimeNow';

    const _CurrentEmployeeCheck1ID = self::Section . '.EmployeeCheck1ID';
    const _CurrentEmployeeCheck2ID = self::Section . '.EmployeeCheck2ID';

    const _CurrentEmployeeCheck1AID = self::Section . '.EmployeeCheck1AID';
    const _CurrentEmployeeCheck2AID = self::Section . '.EmployeeCheck2AID';

    const _CurrentEmployeeCheck1Name = self::Section . '.EmployeeCheck1Name';

    const _CurrentEmployeeCheck2Name = self::Section . '.EmployeeCheck2Name';

    const _CurrentEmployeeQuickRepairID = self::Section . '.CurrentEmployeeQuickRepairID';
    const _CurrentIsReturnRepair = self::Section . '.CurrentIsReturnRepair';
}