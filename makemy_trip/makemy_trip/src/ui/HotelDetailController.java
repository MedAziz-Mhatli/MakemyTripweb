/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package ui;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;

/**
 * FXML Controller class
 *
 * @author Jaouadi Oussama
 */
public class HotelDetailController implements Initializable {

    @FXML
    private TableView<?> Table;
    @FXML
    private TableColumn<?, ?> NomT;
    @FXML
    private TableColumn<?, ?> AdresseT;
    @FXML
    private TableColumn<?, ?> EmailT;
    @FXML
    private TableColumn<?, ?> CodeT;
    @FXML
    private TableColumn<?, ?> PrenomT;
    @FXML
    private TableColumn<?, ?> DiplomeT;
    @FXML
    private TableColumn<?, ?> TelephoneT;
    @FXML
    private Button SuppT;
    @FXML
    private Button mettreT;
    @FXML
    private TextField NomText;
    @FXML
    private TextField AdresseText;
    @FXML
    private TextField EmailText;
    @FXML
    private TextField IDGuideText;
    @FXML
    private TextField PrenomText;
    @FXML
    private TextField DiplomeText;
    @FXML
    private TextField telephoneText;
    @FXML
    private Button Chargerh;
    @FXML
    private Button retour2;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void onDelete(ActionEvent event) {
    }

    @FXML
    private void onUpdate(ActionEvent event) {
    }

    @FXML
    private void loadhotel(ActionEvent event) {
    }

    @FXML
    private void GotoAjouterHotel(ActionEvent event) {
    }
    
}
