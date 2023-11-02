package com.example.sprint_0_android;

import javax.crypto.Cipher;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import java.util.Base64;

public class CifrarDescifrarAES {

    // Propiedades
    private final String cipher = "AES/CBC/PKCS5Padding"; // Método de cifrado
    private final int options = 0; // Opciones
    private final String key = "CleanBajoquetaClientChiperAESKey"; // clave secreta de 32 caracteres
    private final byte[] iv; // vector de inicialización
    private Cipher encryptCipher;
    private Cipher decryptCipher;

    // Constructor
    public CifrarDescifrarAES() {
        this.iv = new byte[16]; // IV de 16 bytes con ceros
        SecretKeySpec secretKeySpec = new SecretKeySpec(key.getBytes(), "AES");
        IvParameterSpec ivSpec = new IvParameterSpec(iv);

        try {
            encryptCipher = Cipher.getInstance(cipher);
            encryptCipher.init(Cipher.ENCRYPT_MODE, secretKeySpec, ivSpec);

            decryptCipher = Cipher.getInstance(cipher);
            decryptCipher.init(Cipher.DECRYPT_MODE, secretKeySpec, ivSpec);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // Método para desencriptar
    public String desencriptar(String text) {
        try {
            byte[] encryptedBytes = Base64.getDecoder().decode(text);
            byte[] decryptedBytes = decryptCipher.doFinal(encryptedBytes);
            return new String(decryptedBytes, "UTF-8"); // Utiliza la codificación UTF-8
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    // Método para encriptar
    public String encriptar(String text) {
        try {
            byte[] textBytes = text.getBytes("UTF-8"); // Utiliza la codificación UTF-8
            byte[] encryptedBytes = encryptCipher.doFinal(textBytes);
            return Base64.getEncoder().encodeToString(encryptedBytes);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
}
