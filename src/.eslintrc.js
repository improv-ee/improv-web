module.exports = {
  "env": {
    "browser": true,
    "commonjs": true,
    "es6": true
  },
  "extends": [
    "eslint:recommended",
    "plugin:vue/recommended",
    "plugin:vue/base",
    "plugin:vue/essential",
    "plugin:vue/strongly-recommended",
    "plugin:vue/recommended"
  ],
  "parserOptions": {
    "sourceType": "module"
  },
  "globals": {
    "axios": "readonly",
    "config": "readonly",
    "_": "readonly",
    "moment": "readonly",
    "Vue": "readonly",
    "jQuery": "readonly"
  },
  "rules": {
  "no-async-promise-executor": "off",
  "no-misleading-character-class": "off",
  "no-prototype-builtins": "off",
  "no-shadow-restricted-names": "off",
  "no-useless-catch": "off",
  "no-with": "off",
  "require-atomic-updates": "off",

  "no-console": "error",
    "indent": [
      "error"
    ],
    "linebreak-style": [
      "error",
      "unix"
    ],
    "quotes": [
      "error",
      "single"
    ],
    "semi": [
      "error",
      "always"
    ],
    "vue/html-closing-bracket-newline": [
      "error",
      {
        "singleline": "never",
        "multiline": "never"
      }
    ]
  }
};
