const fullChinColor = (standart, white, mosaic, beige, violet, sapphire, angora, ebony, velvet, pearl, california, rex, lova, german, blue, fur) => {
    
    const WhoIsLeader = () => {
        if (white == "Нет" && beige != "Нет" && ebony != "Гомоэбони" && ebony != "Нет") return "pastel";
        else if (ebony != "Нет" && ebony != "Носитель") return "ebony";
        else if ((violet == "Есть" && sapphire == "Есть") || (german == "Есть" && sapphire == "Есть") ||
            (violet == "Есть" && german == "Есть")) return "diamond";
        else if (violet == "Есть" || sapphire == "Есть" || german == "Есть") return "notDiamond";
        else if (velvet == "Есть") return "velvet";
        else return "other";
    };
    
    const LEADER = WhoIsLeader ();
    
    const MorFEnd = (point = 3) => {
        if (point == 1) {
            if (LEADER == "pastel") return "ая";
            else return "ой";
        } else if (point == 2) {
            if (LEADER == "pastel") return "ая";
            else return "ий";
        } else {
            if (LEADER == "pastel") return "ая";
            else return "ый";
        }
    };
    
    const ebonyName = (ebony) => {
        let ebonyName = "";
        switch (ebony) {
            case "Носитель": 
                ebonyName = "носитель эбони";
                break;
            case "Светлый": 
                ebonyName = "эбони светлый";
                break;
            case "Средний": 
                ebonyName = "эбони средний";
                break;
            case "Темный": 
                ebonyName = "эбони темный";
                break;
            case "Экстра темный": 
                ebonyName = "эбони экстра темный";
                break;
            case "Гомоэбони": 
                ebonyName = "гомоэбони";
                break;
        }
        return ebonyName;
    };
    
    const isEbony = () => {
        if (ebony != "Нет") {
            if (beige == "Нет") return ebonyName(ebony) + " ";
            else return "";
        } else return "";
    };
    
    const isBeige = () => {
        if (beige != "Нет") {
            if (ebony == "Нет" && white == "Нет") {
                if (beige == "Есть" && !(velvet == "Есть" && white != "Есть" && violet != "Есть" && sapphire != "Есть" &&
                (ebony == "Нет" || ebony == "Носитель") && pearl != "Есть" && california != "Есть" &&
                lova != "Есть" && german != "Есть" && blue != "Есть")) return "гетеробежевый ";
                else if (beige == "Двойной") return "гомобежевый ";
                else return "";
            } else return "";
        } else return "";
    };
    
    const isWHITEPINK = () => {
        if (white == "Есть" && beige == "Нет" && ebony != "Гомоэбони") {
            return "белый ";
        } else if (white == "Есть" && beige != "Нет" && ebony != "Гомоэбони") {
            switch (beige) {
                case "Есть": 
                    return "бело-розовый ";
                case "Двойной": 
                    return "бело-розовый гомобежевый ";
            }
        } else if (white == "Есть" && beige != "Нет" && ebony == "Гомоэбони") {
            switch (beige) {
                case "Есть": 
                    return "белый шоколад ";
                case "Двойной": 
                    return "белый гомобежевый шоколад ";
            }
        } else return "";
    };
    
    const isPASTEL = () => {
        if (white == "Нет" && beige == "Есть" && ebony != "Гомоэбони") {
            switch (ebony) {
                case "Гомоэбони": 
                    return "шоколад ";
                case "Экстра темный": 
                    return "пастель экстра темная ";
                case "Темный": 
                    return "пастель темная ";
                case "Средний": 
                    return "пастель средняя ";
                case "Светлый": 
                    return "пастель светлая ";
                default: 
                    return "";
            }
        } else if (white == "Нет" && beige == "Двойной" && ebony != "Гомоэбони") {
            switch (ebony) {
                case "Гомоэбони": 
                    return "гомобежевый шоколад ";
                case "Экстра темный": 
                    return "гомобежевая пастель экстра темная ";
                case "Темный": 
                    return "гомобежевая пастель темная ";
                case "Средний": 
                    return "гомобежевая пастель средняя ";
                case "Светлый": 
                    return "гомобежевая пастель светлая ";
                default: 
                    return "";
            }
        } else return "";
    };
    
    const isStandart = () => {
        if (standart == "Есть") return "стандарт ";
        else return "";
    };
    
    const isMosaic = () => {
        if (mosaic == "Есть") return "мозаика ";
        else return "";
    };
    
    const isViolet = (POSITION) => {
        if (violet != "Нет" && sapphire != "Есть" && german != "Есть") {
            if (LEADER != "notDiamond") {
                if (POSITION == 1) {
                    switch (violet) {
                        case "Есть": 
                            return `фиолетов${MorFEnd()} `;
                        default: 
                            return "";
                    }
                } else {
                    switch (violet) {
                        case "Носитель": 
                            return "носитель фиолета ";
                        case "67%": 
                            return "67% носитель фиолета ";
                        case "50%": 
                            return "50% носитель фиолета ";
                        default: 
                            return "";
                    }
                }
            } else if (POSITION == 1) return "фиолет ";
            else return "";
        } else if (POSITION == 2) {
            switch (violet) {
                case "Носитель": 
                    return "носитель фиолета ";
                case "67%": 
                    return "67% носитель фиолета ";
                case "50%": 
                    return "50% носитель фиолета ";
                default: 
                    return "";
            }
        }
        else return "";
    };
    
    const isSapphire = (POSITION) => {
        if (sapphire != "Нет" && violet != "Есть" && german != "Есть") {
            if (LEADER != "notDiamond") {
                if (POSITION == 1) {
                    switch (sapphire) {
                        case "Есть": 
                            return `сапфиров${MorFEnd()} `;
                        default: 
                            return "";
                    }
                } else {
                    switch (sapphire) {
                        case "Носитель": 
                            return "носитель сапфира ";
                        case "67%": 
                            return "67% носитель сапфира ";
                        case "50%": 
                            return "50% носитель сапфира ";
                        default: 
                            return "";
                    }
                }
            } else if (POSITION == 1) return "сапфир ";
            else return "";
        } else if (POSITION == 2) {
            switch (sapphire) {
                case "Носитель": 
                    return "носитель сапфира ";
                case "67%": 
                    return "67% носитель сапфира ";
                case "50%": 
                    return "50% носитель сапфира ";
                default: 
                    return "";
            }
        }
        else return "";
    };
    
    const isDIAMOND = () => {
        if (sapphire == "Есть" && violet == "Есть" && german == "Есть") {
            if (LEADER == "diamond") {
                return "триплбриллиант ";
            } else return `триплбриллиантов${MorFEnd()} `;
        } else if (sapphire == "Есть" && violet == "Есть" && german != "Есть") {
            if (LEADER == "diamond") {
                return "бриллиант ";
            } else return `бриллиантов${MorFEnd()} `;
        } else if (sapphire == "Есть" && violet != "Есть" && german == "Есть") {
            if (LEADER == "diamond") {
                return "немецкий бриллиант ";
            } else return `немецк${MorFEnd(2)} бриллиантов${MorFEnd()} `;
        } else if (sapphire != "Есть" && violet == "Есть" && german == "Есть") {
            if (LEADER == "diamond") {
                return "двойной фиолет ";
            } else return `двойн${MorFEnd(2)} фиолетов${MorFEnd()} `;
        } else return "";
    };
    
    const isAngora = (POSITION) => {
        if (angora != "Нет") {
            if (POSITION == 1) {
                switch (angora) {
                    case "Есть": 
                        return "КПА ";
                    default: 
                        return "";
                }
            } else {
                switch (angora) {
                    case "Носитель": 
                        return "НКПА ";
                    case "67%": 
                        return "67% НКПА ";
                    case "50%": 
                        return "50% НКПА ";
                    default: 
                        return "";
                }
            }
        } else return "";
    };
    
    const isVelvet = () => {
        if (velvet == "Есть") {
            if (beige == "Есть" && white != "Есть" && violet != "Есть" && sapphire != "Есть" &&
                (ebony == "Нет" || ebony == "Носитель") && pearl != "Есть" && california != "Есть" &&
                lova != "Есть" && german != "Есть" && blue != "Есть") {
                return "коричневый бархат ";
            } else {
                if (LEADER == "velvet") return "бархат ";
                else return `бархатн${MorFEnd()} `;
            }
        }
        else return "";
    };
    
    const isPearl = (POSITION) => {
        if (pearl != "Нет") {
            if (POSITION == 1) {
                switch (pearl) {
                    case "Есть": 
                        return "жемчуг ";
                    default: 
                        return "";
                }
            } else {
                switch (pearl) {
                    case "Носитель": 
                        return "носитель жемчуга ";
                    case "67%": 
                        return "67% носитель жемчуга ";
                    case "50%": 
                        return "50% носитель жемчуга ";
                    default: 
                        return "";
                }
            }
        } else return "";
    };
    
    const isCalifornia = (POSITION) => {
        if (california != "Нет") {
            if (POSITION == 1) {
                switch (california) {
                    case "Есть": 
                        return `калифорнийск${MorFEnd(2)} бел${MorFEnd()} `;
                    default: 
                        return "";
                }
            } else {
                switch (california) {
                    case "Носитель": 
                        return "носитель калифорнийского белого ";
                    case "67%": 
                        return "67% носитель калифорнийского белого ";
                    case "50%": 
                        return "50% носитель калифорнийского белого ";
                    default: 
                        return "";
                }
            }
        } else return "";
    };
    
    const isRex = (POSITION) => {
        if (rex != "Нет") {
            if (POSITION == 1) {
                switch (rex) {
                    case "Есть": 
                        return "рекс ";
                    default: 
                        return "";
                }
            } else {
                switch (rex) {
                    case "Носитель": 
                        return "носитель рекса ";
                    case "67%": 
                        return "67% носитель рекса ";
                    case "50%": 
                        return "50% носитель рекса ";
                    default: 
                        return "";
                }
            }
        } else return "";
    };
    
    const isLova = (POSITION) => {
        if (lova != "Нет") {
            if (POSITION == 1) {
                switch (lova) {
                    case "Есть": 
                        return "белый Лова ";
                    default: 
                        return "";
                }
            } else {
                switch (lova) {
                    case "Носитель": 
                        return "носитель Лова ";
                    case "67%": 
                        return "67% носитель Лова ";
                    case "50%": 
                        return "50% носитель Лова ";
                    default: 
                        return "";
                }
            }
        } else return "";
    };
    
    const isGerman = (POSITION) => {
        if (german != "Нет" && violet != "Есть" && sapphire != "Есть") {
            if (LEADER != "notDiamond") {
                if (POSITION == 1) {
                    switch (german) {
                        case "Есть": 
                            return `немецк${MorFEnd(2)} фиолетов${MorFEnd()} `;
                        default: 
                            return "";
                    }
                } else {
                    switch (german) {
                        case "Носитель": 
                            return "носитель немецкого фиолета ";
                        case "67%": 
                            return "67% носитель немецкого фиолета ";
                        case "50%": 
                            return "50% носитель немецкого фиолета ";
                        default: 
                            return "";
                    }
                }
            } else if (POSITION == 1) return "немецкий фиолет ";
            else return "";
        } else return "";
    };
    
    const isBlue = () => {
        if (blue == "Есть") return "блю слейт ";
        else return "";
    };
    
    const isFur = () => {
        if (fur == "Есть") return `мехов${MorFEnd(1)} `;
        else return "";
    };
    
    let fullChinColorName = isFur() + isStandart() + isWHITEPINK() + isBeige() + isVelvet() + isViolet(1) + isSapphire(1) + isGerman(1) + isCalifornia(1) +
        isLova(1) + isRex(1) + isDIAMOND() + isPearl(1) + isPASTEL() + isEbony() + isAngora(1) + isBlue() + isMosaic() + isViolet(2) + isSapphire(2) + isGerman(2) + isPearl(2) +
        isAngora(2) + isCalifornia(2) + isRex(2) + isLova(2);
        
    if(fullChinColorName.substring(0, 10) == "бриллиант ") {
    	fullChinColorName = "голубой " + fullChinColorName
    } else if(fullChinColorName.substring(0, 7) == "жемчуг ") {
    	fullChinColorName = "черный " + fullChinColorName
    } else if(fullChinColorName.substring(0, 7) == "бархат ") {
    	fullChinColorName = "черный " + fullChinColorName
    }
        
    fullChinColorName = fullChinColorName[0].toUpperCase() + fullChinColorName.slice(1);
    return fullChinColorName;
};