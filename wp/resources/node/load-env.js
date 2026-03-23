// .envファイルから環境変数を読み取る共通ユーティリティ
import { readFileSync } from 'fs';
import { join } from 'path';

// .envファイルから環境変数を読み取る
export function loadEnv() {
  try {
    const envPath = join(process.cwd(), '.env');
    const envContent = readFileSync(envPath, 'utf-8');
    const envVars = {};

    envContent.split('\n').forEach(line => {
      const trimmedLine = line.trim();
      if (trimmedLine && !trimmedLine.startsWith('#')) {
        const [key, ...valueParts] = trimmedLine.split('=');
        if (key && valueParts.length > 0) {
          envVars[key.trim()] = valueParts.join('=').trim();
        }
      }
    });

    return envVars;
  } catch (error) {
    // .envファイルが存在しない場合は空のオブジェクトを返す
    return {};
  }
}

// 環境変数から値を取得するヘルパー関数
export function getEnv(key, defaultValue) {
  const env = loadEnv();
  return process.env[key] || env[key] || defaultValue;
}

// 真偽値の環境変数を取得するヘルパー関数
export function getEnvBool(key, defaultValue) {
  const value = getEnv(key, defaultValue);
  if (typeof value === 'string') {
    return value.toLowerCase() === 'true' || value === '1';
  }
  return Boolean(value);
}

