package main

import (
	"BSB/BSB/accountcategory"
	"BSB/BSB/assignmentletter"
	"BSB/BSB/bloodtype"
	"BSB/BSB/businessunit"
	"BSB/BSB/businessunittype"
	"BSB/BSB/config"
	"BSB/BSB/corporate"
	"BSB/BSB/department"
	"BSB/BSB/employeepersonal"
	"BSB/BSB/extras"
	"BSB/BSB/handler"
	"BSB/BSB/identitytype"
	"BSB/BSB/item"
	"BSB/BSB/itemcategory"
	"BSB/BSB/itemstock"
	"BSB/BSB/itemstockadjustment"
	"BSB/BSB/itemtype"
	"BSB/BSB/itemuom"
	"BSB/BSB/middleware"
	"BSB/BSB/occupation"
	"BSB/BSB/offtaker"
	"BSB/BSB/partnertype"
	"BSB/BSB/paymenttype"
	"BSB/BSB/persontype"
	"BSB/BSB/position"
	"BSB/BSB/purchaseorder"
	"BSB/BSB/religion"
	"BSB/BSB/repository"
	"BSB/BSB/service"
	"BSB/BSB/status"
	"BSB/BSB/statustype"
	"BSB/BSB/supplier"
	"BSB/BSB/unit"
	"BSB/BSB/uomtype"
	"BSB/BSB/vehicletype"
	"BSB/BSB/weighing"
	"fmt"
	"net/http" //gin + gorilla mux

	"gorm.io/gorm"
)

var (
	db          *gorm.DB                  = config.SetupDBConnection()
	userRepo    repository.UserRepository = repository.NewUserRepository(db)
	userService service.UserService       = service.NewUserService(userRepo)
	authService service.AuthService       = service.NewAuthService(userRepo)
	authHandler handler.AuthHandler       = handler.NewAuthHandler(authService)
	userHandler handler.UserHandler       = handler.NewUserHandler(userService)
)

func main() {
	defer config.CloseDBConnection(db)
	http.HandleFunc("/api/auth/login", authHandler.Login)
	http.HandleFunc("/api/auth/register", authHandler.Register)
	http.Handle("/api/user/profile", middleware.Authorize(http.HandlerFunc(userHandler.Profile)))

	//Blood Type
	http.HandleFunc("/API/bloodType/viewAll", bloodtype.ViewAll)
	http.HandleFunc("/API/bloodType/viewById", bloodtype.ViewById)
	http.HandleFunc("/API/bloodType/insert", bloodtype.Insert)
	http.HandleFunc("/API/bloodType/update", bloodtype.Update)
	http.HandleFunc("/API/bloodType/deleteById", bloodtype.Delete)

	//Payment Type
	http.HandleFunc("/API/paymentType/viewAll", paymenttype.ViewAll)
	http.HandleFunc("/API/paymentType/viewById", paymenttype.ViewById)
	http.HandleFunc("/API/paymentType/insert", paymenttype.Insert)
	http.HandleFunc("/API/paymentType/update", paymenttype.Update)
	http.HandleFunc("/API/paymentType/deleteById", paymenttype.Delete)

	//Account Category
	http.HandleFunc("/API/accountCategory/viewAll", accountcategory.ViewAll)
	http.HandleFunc("/API/accountCategory/viewById", accountcategory.ViewById)
	http.HandleFunc("/API/accountCategory/insert", accountcategory.Insert)
	http.HandleFunc("/API/accountCategory/update", accountcategory.Update)
	http.HandleFunc("/API/accountCategory/deleteById", accountcategory.Delete)

	//Bisnis Unit Type
	http.HandleFunc("/API/businessUnitType/viewAll", businessunittype.ViewAll)
	http.HandleFunc("/API/businessUnitType/viewById", businessunittype.ViewById)
	http.HandleFunc("/API/businessUnitType/insert", businessunittype.Insert)
	http.HandleFunc("/API/businessUnitType/update", businessunittype.Update)
	http.HandleFunc("/API/businessUnitType/deleteById", businessunittype.Delete)

	//Position
	http.HandleFunc("/API/position/viewAll", position.ViewAll)
	http.HandleFunc("/API/position/viewById", position.ViewById)
	http.HandleFunc("/API/position/insert", position.Insert)
	http.HandleFunc("/API/position/update", position.Update)
	http.HandleFunc("/API/position/deleteById", position.Delete)

	//StatusType
	http.HandleFunc("/API/statusType/viewAll", statustype.ViewAll)
	http.HandleFunc("/API/statusType/viewById", statustype.ViewById)
	http.HandleFunc("/API/statusType/insert", statustype.Insert)
	http.HandleFunc("/API/statusType/update", statustype.Update)
	http.HandleFunc("/API/statusType/deleteById", statustype.Delete)

	//identityType
	http.HandleFunc("/API/identityType/viewAll", identitytype.ViewAll)
	http.HandleFunc("/API/identityType/viewById", identitytype.ViewById)
	http.HandleFunc("/API/identityType/insert", identitytype.Insert)
	http.HandleFunc("/API/identityType/update", identitytype.Update)
	http.HandleFunc("/API/identityType/deleteById", identitytype.Delete)

	//Occupation
	http.HandleFunc("/API/occupation/viewAll", occupation.ViewAll)
	http.HandleFunc("/API/occupation/viewById", occupation.ViewById)
	http.HandleFunc("/API/occupation/insert", occupation.Insert)
	http.HandleFunc("/API/occupation/update", occupation.Update)
	http.HandleFunc("/API/occupation/deleteById", occupation.Delete)

	//Partner Type
	http.HandleFunc("/API/partnerType/viewAll", partnertype.ViewAll)
	http.HandleFunc("/API/partnerType/viewById", partnertype.ViewById)
	http.HandleFunc("/API/partnerType/insert", partnertype.Insert)
	http.HandleFunc("/API/partnerType/update", partnertype.Update)
	http.HandleFunc("/API/partnerType/deleteById", partnertype.Delete)

	//Item Type
	http.HandleFunc("/API/itemType/viewAll", itemtype.ViewAll)
	http.HandleFunc("/API/itemType/viewById", itemtype.ViewById)
	http.HandleFunc("/API/itemType/insert", itemtype.Insert)
	http.HandleFunc("/API/itemType/update", itemtype.Update)
	http.HandleFunc("/API/itemType/deleteById", itemtype.Delete)

	//Item Category
	http.HandleFunc("/API/itemCategory/viewAll", itemcategory.ViewAll)
	http.HandleFunc("/API/itemCategory/viewById", itemcategory.ViewById)
	http.HandleFunc("/API/itemCategory/insert", itemcategory.Insert)
	http.HandleFunc("/API/itemCategory/update", itemcategory.Update)
	http.HandleFunc("/API/itemCategory/deleteById", itemcategory.Delete)

	//UOM Type
	http.HandleFunc("/API/uomType/viewAll", uomtype.ViewAll)
	http.HandleFunc("/API/uomType/viewById", uomtype.ViewById)
	http.HandleFunc("/API/uomType/insert", uomtype.Insert)
	http.HandleFunc("/API/uomType/update", uomtype.Update)
	http.HandleFunc("/API/uomType/deleteById", uomtype.Delete)

	//Item UoM
	http.HandleFunc("/API/itemUoM/viewAll", itemuom.ViewAll)
	http.HandleFunc("/API/itemUoM/viewById", itemuom.ViewById)
	http.HandleFunc("/API/itemUoM/insert", itemuom.Insert)
	http.HandleFunc("/API/itemUoM/update", itemuom.Update)
	http.HandleFunc("/API/itemUoM/deleteById", itemuom.Delete)

	//Item
	http.HandleFunc("/API/item/viewAll", item.ViewAll)
	http.HandleFunc("/API/item/viewById", item.ViewById)
	http.HandleFunc("/API/item/insert", item.Insert)
	http.HandleFunc("/API/item/update", item.Update)
	http.HandleFunc("/API/item/deleteById", item.Delete)

	//Corporate
	http.HandleFunc("/API/corporate/viewAll", corporate.ViewAll)
	http.HandleFunc("/API/corporate/viewById", corporate.ViewById)
	http.HandleFunc("/API/corporate/insert", corporate.Insert)
	http.HandleFunc("/API/corporate/update", corporate.Update)
	http.HandleFunc("/API/corporate/deleteById", corporate.Delete)

	//Religion
	http.HandleFunc("/API/religion/viewAll", religion.ViewAll)
	http.HandleFunc("/API/religion/viewById", religion.ViewById)
	http.HandleFunc("/API/religion/insert", religion.Insert)
	http.HandleFunc("/API/religion/update", religion.Update)
	http.HandleFunc("/API/religion/deleteById", religion.Delete)

	//Business Unit
	http.HandleFunc("/API/businessUnit/viewAll", businessunit.ViewAll)
	http.HandleFunc("/API/businessUnit/viewById", businessunit.ViewById)
	http.HandleFunc("/API/businessUnit/insert", businessunit.Insert)
	http.HandleFunc("/API/businessUnit/update", businessunit.Update)
	http.HandleFunc("/API/businessUnit/deleteById", businessunit.Delete)

	//Department
	http.HandleFunc("/API/department/viewAll", department.ViewAll)
	http.HandleFunc("/API/department/viewById", department.ViewById)
	http.HandleFunc("/API/department/insert", department.Insert)
	http.HandleFunc("/API/department/update", department.Update)
	http.HandleFunc("/API/department/deleteById", department.Delete)
	http.HandleFunc("/API/department/viewCombo", department.ViewCombo)

	//Person Type
	http.HandleFunc("/API/personType/viewAll", persontype.ViewAll)
	http.HandleFunc("/API/personType/viewById", persontype.ViewById)
	http.HandleFunc("/API/personType/insert", persontype.Insert)
	http.HandleFunc("/API/personType/update", persontype.Update)
	http.HandleFunc("/API/personType/deleteById", persontype.Delete)

	//Supplier
	http.HandleFunc("/API/supplier/viewAll", supplier.ViewAll)
	http.HandleFunc("/API/supplier/viewById", supplier.ViewById)
	http.HandleFunc("/API/supplier/insert", supplier.Insert)
	http.HandleFunc("/API/supplier/update", supplier.Update)
	http.HandleFunc("/API/supplier/deleteById", supplier.Delete)
	http.HandleFunc("/API/supplier/viewByBuId", supplier.ViewAllByBuId)
	http.HandleFunc("/API/supplier/viewCombo", supplier.ViewCombo)

	//Offtaker
	http.HandleFunc("/API/offtaker/viewAll", offtaker.ViewAll)
	http.HandleFunc("/API/offtaker/viewById", offtaker.ViewById)
	http.HandleFunc("/API/offtaker/insert", offtaker.Insert)
	http.HandleFunc("/API/offtaker/update", offtaker.Update)
	http.HandleFunc("/API/offtaker/deleteById", offtaker.Delete)
	http.HandleFunc("/API/offtaker/viewCombo", offtaker.ViewCombo)
	http.HandleFunc("/API/offtaker/viewByBuId", offtaker.ViewAllByBuId)

	//EmployeePersonal
	http.HandleFunc("/API/employeePersonal/viewAll", employeepersonal.ViewAll)
	http.HandleFunc("/API/employeePersonal/viewById", employeepersonal.ViewById)
	http.HandleFunc("/API/employeePersonal/insert", employeepersonal.Insert)
	http.HandleFunc("/API/employeePersonal/update", employeepersonal.Update)
	http.HandleFunc("/API/employeePersonal/deleteById", employeepersonal.Delete)

	//Unit
	http.HandleFunc("/API/unit/viewAll", unit.ViewAll)
	http.HandleFunc("/API/unit/viewById", unit.ViewById)
	http.HandleFunc("/API/unit/insert", unit.Insert)
	http.HandleFunc("/API/unit/update", unit.Update)
	http.HandleFunc("/API/unit/deleteById", unit.Delete)
	http.HandleFunc("/API/unit/viewCombo", unit.ViewCombo)

	//Assignment Letter
	http.HandleFunc("/API/assignmentLetter/viewAll", assignmentletter.ViewAll)
	http.HandleFunc("/API/assignmentLetter/viewById", assignmentletter.ViewById)
	http.HandleFunc("/API/assignmentLetter/insert", assignmentletter.Insert)
	http.HandleFunc("/API/assignmentLetter/update", assignmentletter.Update)
	http.HandleFunc("/API/assignmentLetter/deleteById", assignmentletter.Delete)
	http.HandleFunc("/API/assignmentLetter/viewByBuId", assignmentletter.ViewByBuId)

	//VehicleType
	http.HandleFunc("/API/vehicleType/viewAll", vehicletype.ViewAll)
	http.HandleFunc("/API/vehicleType/viewById", vehicletype.ViewById)
	http.HandleFunc("/API/vehicleType/insert", vehicletype.Insert)
	http.HandleFunc("/API/vehicleType/update", vehicletype.Update)
	http.HandleFunc("/API/vehicleType/deleteById", vehicletype.Delete)

	//Status
	http.HandleFunc("/API/status/viewAll", status.ViewAll)
	http.HandleFunc("/API/status/viewById", status.ViewById)
	http.HandleFunc("/API/status/insert", status.Insert)
	http.HandleFunc("/API/status/update", status.Update)
	http.HandleFunc("/API/status/deleteById", status.Delete)
	http.HandleFunc("/API/status/viewCombo", status.ViewCombo)

	//Weighing
	http.HandleFunc("/API/weighing/viewAll", weighing.ViewAll)
	http.HandleFunc("/API/weighing/viewByBuId", weighing.ViewByBuId)
	http.HandleFunc("/API/weighing/viewById", weighing.ViewById)
	http.HandleFunc("/API/weighing/insert", weighing.Insert)
	http.HandleFunc("/API/weighing/update", weighing.Update)
	// http.HandleFunc("/API/weighing/deleteById", weighing.Delete)

	//PurchaseOrder
	http.HandleFunc("/API/purchaseOrder/viewAll", purchaseorder.ViewAll)
	http.HandleFunc("/API/purchaseOrder/viewByBuId", purchaseorder.ViewByBuId)
	http.HandleFunc("/API/purchaseOrder/insert", purchaseorder.Insert)
	http.HandleFunc("/API/purchaseOrder/update", purchaseorder.Update)

	//Province
	http.HandleFunc("/API/provinces/viewAll", extras.ViewAllProvince)
	//Cities
	http.HandleFunc("/API/cities/viewAll", extras.ViewAllCities)
	http.HandleFunc("/API/cities/viewByProvinceId", extras.ViewCitiesByProvince)

	//Districts
	http.HandleFunc("/API/districts/viewAll", extras.ViewAllDistricts)
	http.HandleFunc("/API/districts/viewByCityId", extras.ViewDistrictsByCity)

	//Subdistricts
	http.HandleFunc("/API/subdistricts/viewAll", extras.ViewAllSubDistricts)
	http.HandleFunc("/API/subdistricts/viewByDistrictId", extras.ViewSubDistrictsByDistrict)

	//ItemStockAdjustments
	http.HandleFunc("/API/itemStockAdjustments/viewAll", itemstockadjustment.ViewAllISA)
	http.HandleFunc("/API/itemStockAdjustments/viewByBuId", itemstockadjustment.ViewISAByBuId)
	http.HandleFunc("/API/itemStockAdjustments/insert", itemstockadjustment.InsertISA)

	//ItemStock
	http.HandleFunc("/API/itemStock/viewAll", itemstock.ViewAll)
	http.HandleFunc("/API/itemStock/viewByBuId", itemstock.ViewByBuId)

	//Currency
	http.HandleFunc("/API/currency/viewAll", extras.ViewAllCurrency)
	err := http.ListenAndServe(":8080", nil)
	fmt.Println("Running Server on port :8080")
	if err != nil {
		fmt.Println(err)
	}

}
