package extras

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type Money struct {
	IdCurrency   int    `gorm:"column:IdCurrency;primary_key:auto_increament" json:"IdCurrency"`
	CurrencyCode string `gorm:"column:CurrencyCode" json:"CurrencyCode"`
	Currency     string `gorm:"column:currency" json:"currency"`
	Description  string `gorm:"column:Description" json:"Description"`
	IsDeleted    bool   `gorm:"column:IsDeleted" json:"isDeleted"`
}

func ViewAllCurrency(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json; charset=UTF-8")
	if r.Method != http.MethodGet {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	var currency []Money
	result := DB.Raw("CALL viewAll_currency").Take(&currency)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", currency)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
