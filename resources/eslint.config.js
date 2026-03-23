export default [
  {
    files: ['src/_es/**/*.js'],
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module',
      globals: {
        console: 'readonly',
        window: 'readonly',
        document: 'readonly',
      },
    },
    "extends": [
      "eslint:recommended",
      "prettier"             // ← 整形系ルールをオフ
    ],
    rules: {
      'no-console': 'off',
      'quotes': ['error', 'single'],
    },
  },
];
