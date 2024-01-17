import { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'io.ionic.starter',
  appName: 'edpacif Aseg CC',
  webDir: 'www',
  server: {
    androidScheme: 'http',
    //url: 'http://192.168.0.101',
    cleartext: true,
    allowNavigation: ["http://192.168.0.101/Api-Edp-CC/"],

  }
};

export default config;
