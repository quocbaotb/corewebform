<?php

class oWorkManager
{
    //_: Data;
/*    const RuntimeAID = 'WorkManager';
    const Section = RuntimeAID . '.WorkManager';*/
    const Section = 'WorkManager';
    const _Language = self::Section . '.Language';
    const _ServerName = self::Section.'.SeverName';
    const _UserName = self::Section.'.UserName';
    const _Password = self::Section.'.Password';
    const _DatabaseName = self::Section.'.DatabaseName';
    const _CurrentEmployeeAID = self::Section . '.CurrentEmployeeAID';
    const _MachineID = self::Section . 'MachineID';
    const _CurrentBarcodeScanner = self::Section . '.CurrentBarcodeScanner';
    const _CurrentOperationCode = self::Section . '.CurrentOperationCode';
    const _CurrentPlanAID = self::Section . '.CurrentPlanAID';
    const _CurrentCirictLoopItemAID = self::Section . '.CurrentCirictLoopItemAID';
    const _CurrentCommandID = self::Section . '.CurrentCommandID';
    const _CurrentLoopID = self::Section . '.CurrentLoopID';
    const _CurrentMoldTerminalAAID = self::Section . '.CurrentTerminalAAID';
    const _CurrentMoldTerminalBAID = self::Section . '.CurrentTerminalBAID';
    const _CurrentProduceQty = self::Section . '.CurrentProduceQty';
    const _CurrentProducedQty = self::Section . 'CurrentProducedQty';
    const _Current4M = self::Section . '.Current4M';
    const _Current4P = self::Section . '.Current4P';
    const _CurrentMachineID = self::Section.'.MachineID';

    const _CurrentWorkShiftID = self::Section . '.CurrentWorkShiftID';

    const _CurrentUserName = self::Section.'.UserID';
    const _CurrentWebPassword = self::Section . '.Password';

    const _CurrentTypeProgress = self::Section. '.Progress';

    const _CurrentMoldTerminalAID = self::Section. '.CurrentMoldTerminalAID';
    const _CurrentMoldTerminalBID = self::Section. '.CurrentMoldTerminalBID';

    const _CurrentStatus = self::Section. '.CurrentStatus';
    const _CurrentTabControl = self::Section. '.CurrentTabControl';
    const _CurrentOperationName = self::Section. '.CurrentOperationName';
    const _CurrentTableCommand =self::Section. '.TableCommand';

    const scBasEmployeeInfo = "SELECT EmployeeAID, EmployeeID, dbo.fSwitchLang('Language', NameChinese, NameVietnamese, NameEnglish, NameOther) As EmployeeName FROM dbo.vwSysEmployeeInfo";

    const scBasWorkShift = "SELECT WorkShiftID, dbo.fSwitchLang('Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS WorkShiftName FROM dbo.tblBasProduceWorkShift";

    const scBasProduceMachineOperationRef = "SELECT OperationRefID, dbo.fSwitchLang('Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS OperationRefName FROM dbo.tblBasProduceMachineOperationRef";


    const scBasMachineInfo = "SELECT MachineID, dbo.fSwitchLang('Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS MachineName, StoreMoldAAID, StoreMoldBAID FROM dbo.tblBasMachineInfo";

    const scBasMoldInfo = "SELECT MoldAID, MoldID, dbo.fSwitchLang('Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS MoldName FROM dbo.tblBasProduceMold";

    const scBasOperation = "SELECT OperationID, GroupOperation, dbo.fSwitchLang('Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS OperationName FROM dbo.tblBasProduceMachineOperation";

    const scPlanMain = "SELECT PlanAID, PlanID, RecordDate, PlanDate, ProducedQty, CirictLoopItemAID, MachineID, StatusID, MoldTermialAAID, MoldTermialBAID 
                        FROM dbo.tblProduceMachinePlanMain WHERE (PlanAID = '@PlanAID')";

    const scCommandStage = 'SELECT Main.CommandID, Main.Qty, ProducePlan.ProducedQty, Stage.LoopID, MaterialA.ProductID AS TerminalA, MaterialB.ProductID AS TerminalB, Stage.CirictLoopItemAID, ProducePlan.PlanAID, ProducePlan.MachineID, 
                                Stage.SetTerminalA, Stage.SetTerminalB, Stage.SetCut
                            FROM dbo.tblProduceCommandMain AS Main INNER JOIN
                                dbo.tblProduceCommandStage AS Stage ON Main.CommandAID = Stage.CommandAID INNER JOIN
                                dbo.tblProduceMachinePlanMain AS ProducePlan ON Stage.CirictLoopItemAID = ProducePlan.CirictLoopItemAID LEFT OUTER JOIN
                                dbo.tblBasProductInfo AS MaterialA ON Stage.MaterialAIDTerminalA = MaterialA.ProductAID LEFT OUTER JOIN
                                dbo.tblBasProductInfo AS MaterialB ON Stage.MaterialAIDTerminalB = MaterialB.ProductAID';

    const scQualityControl = 'SELECT QualityControlAID, PlanAID, OperationID, RecordDate, EmployeeHandlerAID, Length, TermialAPeeled, TermialAPressing, TermialAFrontHeight, TermialAFrontWidth, 
                                        TermialABackHeight, TermialABackWidth, TermialBPeeled, TermialBPressing, TermialBFrontHeight, TermialBFrontWidth, TermialBBackHeight, TermialBBackWidth, MachineID
                                FROM tblProduceMachinePlanQualityControl';
    const scListMold = 'SELECT ProductID AS Terminal, dbo.GetListMoldFromTerminal(ProductAID) AS ListMold, ProductAID AS ListMoldAID FROM dbo.tblBasProductInfo';

    const scSectionItem = "SELECT SectionItemID, dbo.fSwitchLang('Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS SectionItemName FROM tblWebDesignerSectionItem";
    const scStatus = "SELECT StatusID, dbo.fSwitchLang('Language', NameChinese, NameVietnamese, NameEnglish, NameOther) AS StatusName  FROM dbo.tblBasProduceMachineOperationStatus";

    const scUserInfo = "SELECT UserID, WebPassword, EmployeeAID FROM dbo.tblSysUserInfo WHERE (UserID = '@UserID')";

    const scPlanCommandInfo = "SELECT        CirictLoopItemAID, PlanAID, MachineID, ProducedQty, CommandAID, CommandID, CommandQty, LoopID, MaterialAIDTerminalA, MaterialIDTerminalA, MaterialAIDTerminalB, MaterialIDTerminalB, SetTerminalA, SetTerminalB, SetCut
                                FROM            dbo.GetProduceCommandInfoWeb('@CirictLoopItemAID', '@IsContinue') ";

    const scGetMoldTerminalID = "SELECT ProductID AS TerminalID FROM dbo.tblBasProductInfo WHERE (ProductAID = '@MaterialAIDTerminal')";

    const tbSectionItem = 'tblWebDesignerSectionItem';
    const tbOperationStatus = 'tblBasProduceMachineOperationStatus';
    const tbWorkShift = 'tblBasProduceWorkShift';
    const tbMachineInfo = 'tblBasMachineInfo';
    const tbMold = 'tblBasProduceMold';
    const tbMachineOperation = 'tblBasProduceMachineOperation';
    const tbCommandMain = 'tblProduceCommandMain';
    const tbCommandStage = 'tblProduceCommandStage ';
    const tbPlanMain = 'dbo.tblProduceMachinePlanMain';
    const tbOperation = 'dbo.tblProduceMachinePlanOperation';
    const tbQualityControl = 'dbo.tblProduceMachinePlanQualityControl';
    const tbPlanStop = 'dbo.tblProduceMachinePlanStop';
    const tbUserInfo = 'dbo.tblSysUserInfo';

    const coStatusID = 'StatusID';
    const coStatusName = 'StatusName';
    const coSectionItemID = 'SectionItemID';
    const coSectionItemName = 'SectionItemName';
    const coNameChinese = 'NameChinese';
    const coNameVietnamese = 'NameVietnamese';
    const coNameEnglish = 'NameEnglish';
    const coNameOther = 'NameOther';
    const coInOrder = 'InOrder';
    const coEmployeeAID = 'EmployeeAID';
    const coEmployeeID = 'EmployeeID';
    const coEmployeeName = 'EmployeeName';
    const coWorkShiftID = 'WorkShiftID';
    const coWorkShiftName = 'WorkShiftName';
    const coOperationRefID = 'OperationRefID';
    const coOperationRefName = 'OperationRefName';
    const coMachineID = 'MachineID';
    const coMachineName = 'MachineName';
    const coStoreMoldAAID = 'StoreMoldAAID';
    const coStoreMoldBAID = 'StoreMoldBAID';
    const coMoldAID = 'MoldAID';
    const coMoldID = 'MoldID';
    const coOperationID = 'OperationID';
    const coGroupOperation = 'GroupOperation';
    const coDescriptionNameChinese = 'DescriptionNameChinese';
    const coCommandAID = 'CommandAID';
    const coCommandID = 'CommandID';
    const coLoopID = 'LoopID';
    const coCirictLoopItemAID = 'CirictLoopItemAID';
    const coPlanAID = 'PlanAID';
    const coPlanID = 'PlanID';
    const coRecordDate = 'RecordDate';
    const coPlanDate = 'PlanDate';
    const coMoldTermialAAID = 'MoldTermialAAID';
    const coMoldTermialBAID = 'MoldTermialBAID';
    const coOperationAID = 'OperationAID';
    const coEmployeeHandlerAID = 'EmployeeHandlerAID';
    const coQualityControlAID = 'QualityControlAID';
    const coLength = 'Length';
    const coTermialAPeeled = 'TermialAPeeled';
    const coTermialAPressing = 'TermialAPressing';
    const coTermialAFrontHeight = 'TermialAFrontHeight';
    const coTermialAFrontWidth = 'TermialAFrontWidth';
    const coTermialABackHeight = 'TermialABackHeight';
    const coTermialABackWidth = 'TermialABackWidth';
    const coTermialBPeeled = 'TermialBPeeled';
    const coTermialBPressing = 'TermialBPressing';
    const coTermialBFrontHeight = 'TermialBFrontHeight';
    const coTermialBFrontWidth = 'TermialBFrontWidth';
    const coTermialBBackHeight = 'TermialBBackHeight';
    const coTermialBBackWidth = 'TermialBBackWidth';
    const coStopAID = 'StopAID';
    const coEmployeeRepairAID = 'EmployeeRepairAID';
    const coRepairTime = 'RepairTime';
    const coTerminal = 'Terminal';
    const coListMold = 'ListMold';
    const coListMoldAID = 'ListMoldAID';
    const coSetTerminalA = 'SetTerminalA';
    const coSetTerminalB = 'SetTerminalB';
    const coProduceMachineID = 'ProduceMachineID';
    const coProducedQty = 'ProducedQty';
    const coQty = 'Qty';
    const coSetCut = 'SetCut';
    const coUserName = 'UserID';
    const coWebPassword = 'WebPassword';


}