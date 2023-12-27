package utils

import (
	"bytes"
	"encoding/json"
	"fmt"
	"io/ioutil"
	"net/http"
	"os"
)

type responds struct {
	Status  bool        `json:"status"`
	Message string      `json:"message"`
	Data    interface{} `json:"data"`
}

func Auth_Server_Req(datas interface{}, path string) (responds, error) {
	marshalled, err := json.Marshal(datas)
	if err != nil {
		fmt.Println(err)
	}
	Jwt_server := os.Getenv("JWT_Server") + path
	req, err := http.NewRequest("POST", Jwt_server, bytes.NewReader(marshalled))
	req.Header.Add("Content-Type", "application/json")
	if err != nil {
		fmt.Println(err)
	}
	client := &http.Client{}
	res, err := client.Do(req)
	if err != nil {
		fmt.Println(err)
	}
	defer res.Body.Close()
	body, err := ioutil.ReadAll(res.Body)
	if err != nil {
		fmt.Println(err)
	}
	var reqresponds responds
	err = json.Unmarshal(body, &reqresponds)
	if err != nil || reqresponds.Status != true {
		fmt.Println(err)
	}
	return reqresponds, nil
}


