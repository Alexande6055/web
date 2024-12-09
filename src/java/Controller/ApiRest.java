/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Controller;

import java.io.BufferedReader;
import java.io.DataOutput;
import java.io.DataOutputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 *
 * @author juanp
 */
public class ApiRest {

    private final String apiUrl = "http://localhost/SERVICIOS/Ejercicio2/controllers/apiRest.php";

    public String getStudiantes() {
        StringBuilder resultado = new StringBuilder();
        try {
            URL url = new URL(apiUrl);
            HttpURLConnection connecion = (HttpURLConnection) url.openConnection();
            connecion.setRequestMethod("GET");
            if (connecion.getResponseCode() == HttpURLConnection.HTTP_OK) {
                BufferedReader reader = new BufferedReader(new InputStreamReader(connecion.getInputStream()));
                String line;
                while ((line = reader.readLine()) != null) {
                    resultado.append(line);
                }
                reader.close();
            } else {
                System.out.println("Error de conneccion: " + connecion.getResponseCode());
            }
            connecion.disconnect();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return resultado.toString();
    }

    private String sendRequest(String method, String cedula, String nombre, String apellido, String direccion, String telefono) {
        try {
            URL url = new URL(apiUrl);

            HttpURLConnection connection = (HttpURLConnection) url.openConnection();
            connection.setRequestMethod(method);
            connection.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");
            connection.setDoOutput(true);
            String params = "cedula=" + cedula + "nombre=" + nombre + "apellido=" + apellido + "direccion=" + direccion + "telefono=" + telefono;
            DataOutputStream write = new DataOutputStream(connection.getOutputStream());
            write.writeBytes(params);
            write.flush();
            write.close();

            BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
            String line;
            StringBuilder response = new StringBuilder();
            while ((line = reader.readLine()) != null) {
                response.append(line);
            }
            reader.close();
            return response.toString();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return "Error al procesar la Solicitud";

    }

    public String saveStudent(String cedula, String nombre, String apellido, String direccion, String telefono) {
        return sendRequest("POST", cedula, nombre, apellido, direccion, telefono);
    }

    public String updateStudent(String cedula, String nombre, String apellido, String direccion, String telefono) {
        return sendRequest("PUT", cedula, nombre, apellido, direccion, telefono);
    }

    public String deleteStudiantes(String cedula) {
        StringBuilder resultado = new StringBuilder();
        try {
            URL url = new URL(apiUrl + "?cedula=" + cedula);
            HttpURLConnection connecion = (HttpURLConnection) url.openConnection();
            connecion.setRequestMethod("DELETE");
            if (connecion.getResponseCode() == HttpURLConnection.HTTP_OK) {
                BufferedReader reader = new BufferedReader(new InputStreamReader(connecion.getInputStream()));
                String line;
                while ((line = reader.readLine()) != null) {
                    resultado.append(line);
                }
                reader.close();
            } else {
                System.out.println("Error de conneccion: " + connecion.getResponseCode());
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
        return resultado.toString();
    }
    
    public String getStudiant(String cedula) {
        StringBuilder resultado = new StringBuilder();
        try {
            URL url = new URL(apiUrl + "?cedula=" + cedula);
            HttpURLConnection connecion = (HttpURLConnection) url.openConnection();
            connecion.setRequestMethod("GET");
            if (connecion.getResponseCode() == HttpURLConnection.HTTP_OK) {
                BufferedReader reader = new BufferedReader(new InputStreamReader(connecion.getInputStream()));
                String line;
                while ((line = reader.readLine()) != null) {
                    resultado.append(line);
                }
                reader.close();
            } else {
                System.out.println("Error de conneccion: " + connecion.getResponseCode());
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
        return resultado.toString();
    }

}
