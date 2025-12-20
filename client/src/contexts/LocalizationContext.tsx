import React, { createContext, useContext } from "react";
import { useLocalization } from "@/hooks/useLocalization";

interface LocalizationContextType {
  locale: "en" | "ar";
  setLocale: (locale: "en" | "ar") => void;
  t: (key: string, defaultValue?: string) => string;
  toggleLocale: () => void;
  isLoading: boolean;
}

const LocalizationContext = createContext<LocalizationContextType | undefined>(
  undefined
);

export function LocalizationProvider({
  children,
}: {
  children: React.ReactNode;
}) {
  const localization = useLocalization();

  return (
    <LocalizationContext.Provider value={localization}>
      {children}
    </LocalizationContext.Provider>
  );
}

export function useTranslation() {
  const context = useContext(LocalizationContext);
  if (!context) {
    throw new Error(
      "useTranslation must be used within LocalizationProvider"
    );
  }
  return context;
}
